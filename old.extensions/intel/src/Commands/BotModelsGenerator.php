<?php

namespace extensions\cornatul-intel\src\Commands;

use intel\src\Channels\Models;
use intel\src\Jobs\GeneratePost;
use intel\src\Jobs\GenerateQuestion;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

class BotModelsGenerator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bot:generate-models';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate 3d models for trains so from the forum posts';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->info('Hello, Master Welcome to our question extractor and generator!');

        $this->info('Models posts extracted');
        $this->info('Generating description for models');


        $pages = 62;
        for ($i = 1; $i <= $pages; $i++) {
            $this->info('Generating models from page ' . $i);
            $models = $this->getModels($i);
            $models->each(function ($post) {

                $this->info('Generating questions from ' . $post['title']);

                $instruction = 'You are a forum user passioned about train models who gets some information
                about a 3d model and uses that to create a more funny version of the content';

                $context = $this->getContext($post['link']);

                $this->info('Generating cloudflare job for ' . $post['title']);

                $channel = Models::CHANNEL_ID;

                dispatch(new GeneratePost($instruction, $context, $channel))
                    ->delay(now()->addSeconds(15));
            });
        }
        //dispatch

    }


    private function getModels(int $page): Collection
    {
        $base_url = 'https://cults3d.com';
        $collections = collect();
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', $base_url ."/en/search?only_safe=false&page={$page}&q=trains");
        $body = $response->getBody();

        //use dom crawler to extract the links
        $crawler = new \Symfony\Component\DomCrawler\Crawler($body->getContents());
        $crawler->filter('div.drawer-sliding')->each(function ($node) use ($collections,$base_url) {
            $title = $node->filter('h3')->text();
            $link = $node->filter('a')->attr('href');
            $collections->push([
                'title' => $title,
                'link' => $base_url.$link
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


       return $crawler->filter('#hide-and-seek__content-about > div > div:nth-child(1) > div:nth-child(1)')->each(function ($node) {
            //todo make it markdown
            return $node->text();
        })[0];
    }


}
