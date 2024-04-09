<?php
declare(strict_types=1);
namespace App\Clients;

use App\Data\DTO\ArticleDTO;
use App\Saloon\Connectors\WordpressConnector;
use App\Saloon\Requests\WordpressRequests\CreateCategoryRequest;
use App\Saloon\Requests\WordpressRequests\CreatePostRequest;
use App\Saloon\Requests\WordpressRequests\CreateTagRequest;
use App\Saloon\Requests\WordpressRequests\SearchPostRequest;
use Cornatul\Wordpress\DTO\WordpressPostDTO;
use Cornatul\Wordpress\Models\WordpressWebsite;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Lucid\Units\Job;
use Saloon\Exceptions\InvalidResponseClassException;
use Saloon\Exceptions\PendingRequestException;
use Saloon\Http\Auth\BasicAuthenticator;

/**
 * Class WordpressRestClient
 * @package App\Clients
 */
final class WordpressRestClient extends Job implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $timeout = 120;

    private WordpressConnector $wordpressConnector;

    /**
     * WordpressRestClient constructor.
     * @param ArticleDTO $article
     * @param WordpressWebsite $website
     */
    function __construct(private readonly ArticleDTO $article, private readonly WordpressWebsite $website)
    {
        $this->wordpressConnector = $this->buildConnector();
    }

    /**
     * @return int|null
     * @throws InvalidResponseClassException
     * @throws PendingRequestException
     * @throws \ReflectionException
     */
    public final function handle(): ?int
    {
        if ($this->checkIfPostExists()) {
            return null;
        }

        $category = collect(json_decode($this->article->keywords, true))->first();
        $categoryId = $this->getOrCreateCategories($category);
        $tagIds = $this->getOrCreateTags($this->article->keywords);

        $postDTO = WordpressPostDTO::from([
            'title' => $this->article->title,
            'content' => $this->article->spacy,
            'status' => 'publish',
            'categories' => [$categoryId],
            'tags' => $tagIds,
        ]);

        $response = $this->wordpressConnector->send(new CreatePostRequest($postDTO));

        return $response->collect('id')->first();
    }

    /**
     * @param string $category
     * @return int
     * @throws InvalidResponseClassException
     * @throws PendingRequestException
     * @throws \ReflectionException
     */
    private function getOrCreateCategories(string $category): int
    {
        $categoryRequest = $this->wordpressConnector->send(new CreateCategoryRequest($category));
        $termId = $categoryRequest->collect('data')->collect('term_id')->first() ?? $categoryRequest->collect('id')->first();
        return $termId ?: 0;
    }

    /**
     * @param string $tags
     * @return array
     * @throws InvalidResponseClassException
     * @throws PendingRequestException
     * @throws \ReflectionException
     */
    private function getOrCreateTags(string $tags): array
    {
        $tagIds = [];

        foreach (json_decode($tags, true) as $tag) {
            $response = $this->wordpressConnector->send(new CreateTagRequest($tag));

            if ($existingTermId = $response->collect('data')->collect('term_id')->first()) {
                $tagIds[] = $existingTermId;
            } elseif ($newTagId = $response->collect('id')->first()) {
                $tagIds[] = $newTagId;
            }
        }

        return $tagIds;
    }

    /**
     * @return bool
     * @throws InvalidResponseClassException
     * @throws PendingRequestException
     * @throws \ReflectionException
     */
    private function checkIfPostExists(): bool
    {
        //todo check
        $response = $this->wordpressConnector->send(new SearchPostRequest($this->article));
        return count(json_decode($response->body())) > 0;
    }

    /**
     * @return WordpressConnector
     */
    private function buildConnector(): WordpressConnector
    {
        return  (new WordpressConnector($this->website->database_host))
            ->authenticate(new BasicAuthenticator($this->website->database_user,  $this->website->database_pass));
    }
}
