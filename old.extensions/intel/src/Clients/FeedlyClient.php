<?php
declare(strict_types=1);
namespace  SaturnPHP\Intel\Clients;


use SaturnPHP\Intel\Connectors\FeedlyConnector;
use SaturnPHP\Intel\Contracts\FeedManager;
use SaturnPHP\Intel\Requests\FeedlyTopicRequest;
use GuzzleHttp\Exception\GuzzleException;
use SaturnPHP\Intel\DTO\FeedDto;
use Saloon\Exceptions\InvalidResponseClassException;
use Saloon\Exceptions\PendingRequestException;


class FeedlyClient implements FeedManager
{
    /**
     * @method find
     */
    final public function find(string $topic, string $language = 'en'): FeedDto
    {

        try {

            $feedlyConnector = new FeedlyConnector();

            $response = $feedlyConnector->send(new FeedlyTopicRequest($topic));

            return FeedDto::from($response->json());

        } catch (GuzzleException|\ReflectionException|InvalidResponseClassException|PendingRequestException $exception) {

            logger($exception->getMessage());
        }

        return FeedDto::from([]);

    }

}
