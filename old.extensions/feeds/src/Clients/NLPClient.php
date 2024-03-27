<?php
declare(strict_types=1);
namespace SaturnPHP\Feeds\Clients;

use SaturnPHP\Feeds\Connectors\FeedlyConnector;
use SaturnPHP\Intel\Connectors\NlpConnector;
use SaturnPHP\Feeds\Contracts\ArticleManager;
use SaturnPHP\Feeds\Contracts\FeedManager;
use SaturnPHP\Feeds\Contracts\FeedFinderInterface;
use SaturnPHP\Feeds\DTO\ArticleDto;
use SaturnPHP\Feeds\Requests\FeedlyTopicRequest;
use SaturnPHP\Intel\Requests\GetArticleRequest;
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
