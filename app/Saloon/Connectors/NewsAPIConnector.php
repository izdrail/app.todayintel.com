<?php
declare(strict_types=1);
namespace App\Saloon\Connectors;
use Saloon\Http\Connector;
use Saloon\Traits\Plugins\HasTimeout;

/**
 * https://newsapi.org/v2/everything?q=apple&from=2024-03-02&to=2024-03-02&sortBy=popularity&apiKey=c29a123962034057aac547e7321be062
 */
final class NewsAPIConnector extends Connector
{
    use HasTimeout;

    public function resolveBaseUrl(): string
    {
        return 'https://newsapi.org/v2/';
    }

    protected function defaultHeaders(): array
    {
        return [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
    }

}
