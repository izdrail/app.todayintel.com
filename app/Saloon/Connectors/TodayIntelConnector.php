<?php
declare(strict_types=1);
namespace App\Saloon\Connectors;
use Saloon\Http\Connector;
use Saloon\Traits\Plugins\HasTimeout;


final class TodayIntelConnector extends Connector
{
    use HasTimeout;

    public function resolveBaseUrl(): string
    {
        return 'http://apptodayintelcom-api.todayintel.com-1:8001';
    }

    protected function defaultHeaders(): array
    {
        return [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
    }

}
