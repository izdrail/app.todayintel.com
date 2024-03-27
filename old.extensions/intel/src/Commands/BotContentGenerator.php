<?php

namespace  SaturnPHP\Intel\Commands;

use  SaturnPHP\Intel\Channels\Heljan;
use  SaturnPHP\Intel\Jobs\GeneratePost;
use  SaturnPHP\Intel\Jobs\GenerateQuestion;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

class BotContentGenerator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bot:generate-content';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate questions from the forum posts';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->info('Hello, Master Welcome to our question extractor and generator!');
        $links = $this->getLinks();
        $this->info('Generate content from the ril model database');

        //dispatch
        $links->each(function ($post) {

            $this->info('Generating questions from ' . $post['title']);

            //instructions
            $instruction = 'You are a forum user passioned about train models who gets some some information about a
            train model and uses that information to create a funny description of that model';

            $context = $this->getContext($post['link']);

            $this->info('Generating content using cloudflare llama2  - dispatching  job for ' . $post['title']);

            $channel = Heljan::CHANNEL_ID;

            dispatch(new GeneratePost($instruction, $context, $channel))
                ->delay(now()->addSeconds(15));
        });
    }


    private function getLinks(): Collection
    {
        $collections = collect();
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', 'https://www.modelraildatabase.com/heljan/locomotives/');
        $body = $response->getBody();

        //use dom crawler to extract the links
        $crawler = new \Symfony\Component\DomCrawler\Crawler($body->getContents());
        $crawler->filter('body > main > div > div.pt-3.ps-lg-2 > table > tbody > tr')->each(function ($node) use ($collections) {
            $title = $node->filter('td:nth-child(4)')->text();
            $link = $node->filter('td:nth-child(1) > a')->attr('href');
            $collections->push([
                'title' => $title,
                'link' => 'https://www.modelraildatabase.com'.$link
            ]);
        });

        return $collections;
    }

    private function getContext(string $link): string
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', $link);
        $body = $response->getBody();
        //use dom crawler to extract the links
        $crawler = new \Symfony\Component\DomCrawler\Crawler($body->getContents());


       $context = $crawler->filter('.container-xxl div.row')->each(function ($node) {
            //todo make it markdown
            return $node->text();
        });

        return $context[0];
    }


}
