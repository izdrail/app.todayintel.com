<?php
declare(strict_types=1);
namespace App\Saloon\Connectors;

use Saloon\Http\Connector;
use Saloon\Traits\Plugins\HasTimeout;


final class TodayIntelConnector extends Connector
{
    use HasTimeout;

    protected int $connectTimeout = 60;

    protected int $requestTimeout = 120;


    public function resolveBaseUrl(): string
    {
        return 'host.docker.internal:8001';
    }

    function defaultHeaders(): array
    {
        return [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
    }

}
