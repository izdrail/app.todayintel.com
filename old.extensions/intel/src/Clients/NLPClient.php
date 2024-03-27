<?php
declare(strict_types=1);
namespace  SaturnPHP\Intel\Clients;

use Cornatul\Feeds\Connectors\FeedlyConnector;
use intel\src\Connectors\NlpConnector;
use Cornatul\Feeds\Contracts\ArticleManager;
use Cornatul\Feeds\Contracts\FeedManager;
use Cornatul\Feeds\Contracts\FeedFinderInterface;
use Cornatul\Feeds\DTO\ArticleDto;
use Cornatul\Feeds\Requests\FeedlyTopicRequest;
use intel\src\Requests\GetArticleRequest;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use JsonException;
use Cornatul\Feeds\DTO\FeedDto;
use Saloon\Exceptions\InvalidResponseClassException;
use Saloon\Exceptions\PendingRequestException;
use Spatie\SchemaOrg\Contracts\ArticleContract;


class NLPClient implements ArticleManager
{
    /**
     * @method find
     */
    final public function find(string $url, string $language = "en"): ArticleDto
    {

        try {

            $nlpConnector = new NlpConnector();

            $response = $nlpConnector->send(new GetArticleRequest($url, $language));

            return ArticleDto::from($response->json());

        } catch (GuzzleException|\ReflectionException|InvalidResponseClassException|PendingRequestException $exception) {

            logger($exception->getMessage());
        }

        return ArticleDto::from([]);

    }

    public function extract(string $url): ArticleDto
    {
        // TODO: Implement extract() method.
    }
}
