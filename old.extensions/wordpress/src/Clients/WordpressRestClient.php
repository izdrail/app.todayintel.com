<?php

namespace Cornatul\Wordpress\Clients;

use Cornatul\Feeds\Models\Article;
use Cornatul\Wordpress\Connector\WordpressConnector;
use Cornatul\Wordpress\DTO\WordpressPostDTO;
use Cornatul\Wordpress\Models\WordpressWebsite;
use Cornatul\Wordpress\WordpressRequests\CreateCategoryRequest;
use Cornatul\Wordpress\WordpressRequests\CreatePostRequest;
use Cornatul\Wordpress\WordpressRequests\CreateTagRequest;
use Cornatul\Wordpress\WordpressRequests\SearchPostRequest;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\Jobs\Job;
use Saloon\Exceptions\InvalidResponseClassException;
use Saloon\Exceptions\PendingRequestException;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Bus\Queueable;

/**
 *
 */
final class WordpressRestClient implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $timeout = 120;

    private WordpressConnector $wordpressConnector;

    /**
     * @param Article $article
     * @param WordpressWebsite $website
     */
    function __construct(private readonly Article $article, private readonly WordpressWebsite $website)
    {
       $this->wordpressConnector =  $this->setConnection();
    }

    /**
     *
     * @throws \ReflectionException
     * @throws InvalidResponseClassException
     * @throws PendingRequestException
     */
    public final function handle(): int|null
    {
        $exists = $this->checkIfPostExists();

        if ($exists) {
            return null;
        }

        $category = collect(
            json_decode($this->article->keywords, true)
        )->first();

        $categories =  $this->getOrCreateCategories($category);

        $tags = $this->getOrCreateTags($this->article->keywords);

        $postDTO = WordpressPostDTO::from([
            'title' => $this->article->title,
            'content' => $this->article->spacy,
            'status' => 'publish',
            'categories' => [$categories],
            'tags' => $tags,
        ]);


       $response =  $this->wordpressConnector->send(new CreatePostRequest($postDTO));

       return ($response->collect('id')->first());

    }


    /**
     * @throws InvalidResponseClassException
     * @throws \ReflectionException
     * @throws PendingRequestException
     * @throws \Exception
     */
    private function getOrCreateCategories(string $category): int
    {

        $categoryRequest = $this->wordpressConnector->send(new CreateCategoryRequest($category));

        $code = ($categoryRequest->collect('code')->first());

        if ($code === 'term_exists') {
            return $categoryRequest->collect('data')->collect('term_id')->collect('term_id')->toArray()['term_id'];
        }

        return $categoryRequest->collect('id')->first();
    }

    /**
     * @throws \ReflectionException
     * @throws InvalidResponseClassException
     * @throws PendingRequestException
     */
    private function getOrCreateTags(string $tags): array
    {
        $tags = json_decode($tags, true);

        $ids = collect();

        foreach ($tags as $tag) {
            $response = $this->wordpressConnector->send(new CreateTagRequest($tag));
            if ($response->collect('code')->first() === 'term_exists') {
                $existingTerm = $response->collect('data')->collect('term_id');
                $ids->push($existingTerm['term_id']);
            }
            if($response->collect('id')->isNotEmpty()){
                $ids->push($response->collect('id')->first());
            }
        }
        return ($ids->toArray());
    }

    private function setConnection():WordpressConnector
    {
        $connector = new WordpressConnector($this->website->database_host);

        $connector->withBasicAuth($this->website->database_user, $this->website->database_pass);

        return $connector;
    }


    private function checkIfPostExists(): bool
    {

        $response =  $this->wordpressConnector->send(new SearchPostRequest($this->article));
        $body = json_decode($response->body());
        if (count($body) > 0) {
            return true;
        }
        return false;
    }
}
