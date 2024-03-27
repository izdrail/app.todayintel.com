<?php
declare(strict_types=1);
namespace App\Saloon\Connectors;

use Saloon\Http\Connector;
use Saloon\Traits\Plugins\HasTimeout;

class HackerNewsConnector extends Connector
{
    protected int $connectTimeout = 60;


    use HasTimeout;

    public function __construct()
    {

    }


    final function resolveBaseUrl(): string
    {
        return 'https://hnrss.org/';
    }

    final function defaultHeaders(): array
    {
        return [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token
        ];
    }

}
