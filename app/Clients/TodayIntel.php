<?php
declare(strict_types=1);
namespace App\Clients;
use Saloon\Http\Connector;
use Saloon\Traits\Plugins\HasTimeout;


final class TodayIntel extends Connector
{
    use HasTimeout;

    public function resolveBaseUrl(): string
    {
        return 'https://api.todayintel.com';
    }

    protected function defaultHeaders(): array
    {
        return [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
    }

}
