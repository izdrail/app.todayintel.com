<?php
declare(strict_types=1);
namespace App\Clients;

use Saloon\Http\Connector;
use Saloon\Traits\Plugins\HasTimeout;

final class Cloudflare extends Connector
{

    protected int $connectTimeout = 60;

    protected int $requestTimeout = 120;


    use HasTimeout;

    public function resolveBaseUrl(): string
    {
        return 'https://api.cloudflare.com/client/v4/accounts';
    }

    final function defaultHeaders(): array
    {
        return [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
    }
    public function __construct(protected readonly string $text) {
        //
    }
}
