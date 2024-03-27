<?php

namespace extensions\cornatul-intel\src\Commands;

use intel\src\Jobs\GenerateQuestion;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

class BotQuestionGenerator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bot:generate-questions';

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
        $hornby = $this->getHornby();
        $this->info('Hornby forum posts extracted');
        $this->info('Generating questions from Hornby forum posts');

        //dispatch
        $hornby->each(function ($post) {

            $this->info('Generating questions from ' . $post['title']);

            $instruction = 'You are a forum user passioned about train models who gets some some question about model trains and uses that question to create  a more funny version of the question';

            $context = $this->getContext($post['link']);

            $this->info('Generating cloudflare job for ' . $post['title']);

            dispatch(new GenerateQuestion($instruction, $context))
                ->delay(now()->addSeconds(15));
        });
    }


    private function getHornby(): Collection
    {
        $collections = collect();
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', 'https://uk.hornby.com/community/forum/general-discussion');
        $body = $response->getBody();

        //use dom crawler to extract the links
        $crawler = new \Symfony\Component\DomCrawler\Crawler($body->getContents());
        $crawler->filter('a.forum-post')->each(function ($node) use ($collections) {
            $title = ($node->filter('h2')->text());
            $link = $node->attr('href');
            $collections->push([
                'title' => $title,
                'link' => $link
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


       $contenxt = $crawler->filter('div.grid__item.grid__item--80.u-pos-rel.u-mt-half.u-mb0 > div.wysiwyg.u-pr-quad.u-size-small')->each(function ($node) {
            //todo make it markdown
            return $node->html();
        });

        return $contenxt[0];
    }


}
