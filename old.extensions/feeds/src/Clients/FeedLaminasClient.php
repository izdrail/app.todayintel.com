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
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use JsonException;
use Cornatul\Feeds\DTO\FeedDto;
use Saloon\Exceptions\InvalidResponseClassException;
use Saloon\Exceptions\PendingRequestException;



class FeedLaminasClient implements \Laminas\Feed\Reader\Http\ClientInterface
{

    private int $statusCode = 200;

    private string $body = '';

    /**
     * @method get
     * @param string $uri
     * @throws GuzzleException
     */
    final public function get($uri): self
    {
        $client = new Client();

        $response =  $client->get($uri);

        $this->body = $response->getBody()->getContents();

        $this->statusCode = $response->getStatusCode();

        return $this;
    }

    final public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    final public function getBody(): string
    {
        return $this->body;
    }
}
