<?php
declare(strict_types=1);
namespace App\Saloon\Connectors;

use Illuminate\Support\Facades\Config;
use Saloon\Http\Connector;
use Saloon\Traits\Plugins\HasTimeout;

class CloudflareConnector extends Connector
{
    protected int $connectTimeout = 60;

    protected int $requestTimeout = 120;

    protected string $account;

    protected string $token;

    use HasTimeout;

    public function __construct()
    {
        $this->account = config('social.account') ?? "";
        $this->token = config('social.token') ?? "";
    }


    final function resolveBaseUrl(): string
    {
        return 'https://api.cloudflare.com/client/v4/accounts/' . $this->account;
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
