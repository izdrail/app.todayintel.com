<?php
declare(strict_types=1);
namespace SaturnPHP\Feeds\Connectors;
use Saloon\Http\Connector;
class FeedlyConnector extends Connector
{
    public function resolveBaseUrl(): string
    {
        return 'https://feedly.com/v3/';
    }

    protected function defaultHeaders(): array
    {
        return [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
    }
}
