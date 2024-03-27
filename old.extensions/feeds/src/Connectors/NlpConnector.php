<?php
declare(strict_types=1);
namespace SaturnPHP\Feeds\Connectors;
use League\Flysystem\Config;
use Saloon\Contracts\MockClient;
use Saloon\Contracts\Request;
use Saloon\Contracts\Response;
use Saloon\Http\Connector;

/**
 * Class NlpConnector
 * @method send(Request $request, MockClient $mockClient = null)
 */
class NlpConnector extends Connector
{
    public function resolveBaseUrl(): string
    {
        return config('feeds.nlp-api-url');
    }

    protected function defaultHeaders(): array
    {
        return [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
    }
}
