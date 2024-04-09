<?php

declare(strict_types=1);

namespace App\Service\Articles;


use App\Contracts\Articles\ExtractArticle;
use App\Data\DTO\ArticleDTO;
use App\Data\Models\Article;
use App\Saloon\Connectors\TodayIntelConnector;
use App\Saloon\Requests\Today\ExtractArticleRequest;
use Lucid\Units\Feature;
use  \App\Jobs\Articles\ExtractArticleJob;
use ReflectionException;
use Saloon\Exceptions\InvalidResponseClassException;
use Saloon\Exceptions\PendingRequestException;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;


final class ExtractArticlesService extends Feature implements ExtractArticle
{

    public function __construct(
        private readonly Article $article,
    )
    {
    }

    /**
     * @throws InvalidResponseClassException
     * @throws ReflectionException
     * @throws FatalRequestException
     * @throws PendingRequestException
     * @throws RequestException
     */
    public function handle(): ArticleDTO
    {
       return $this->extractArticle();
    }

    /**
     * @throws InvalidResponseClassException
     * @throws FatalRequestException
     * @throws ReflectionException
     * @throws RequestException
     * @throws PendingRequestException
     */
    public function extractArticle(): ArticleDTO
    {
        $connector = new TodayIntelConnector();

        $response =  $connector->send(new ExtractArticleRequest($this->article->link));

        if($response->status() !== 200){
            throw new \ReflectionException('Something went wrong with the api ' . $response->body());
        }

        return $response->dtoOrFail();
    }
}
