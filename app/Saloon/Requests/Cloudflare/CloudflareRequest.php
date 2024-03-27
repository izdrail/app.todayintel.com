<?php

namespace App\Saloon\Requests\Cloudflare;

use App\Agents\BaseAgent;
use League\Flysystem\Filesystem;
use Saloon\CachePlugin\Contracts\Cacheable;
use Saloon\CachePlugin\Contracts\Driver;
use Saloon\CachePlugin\Traits\HasCaching;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;
use Illuminate\Support\Facades\Cache;
use Saloon\CachePlugin\Drivers\LaravelCacheDriver;

class CloudflareRequest extends Request implements Cacheable,HasBody
{
    use HasCaching;

    use HasJsonBody;

    protected Method $method = Method::POST;


    public function __construct(private readonly BaseAgent $agent)
    {
    }

    final function resolveCacheDriver(): Driver
    {
        return new LaravelCacheDriver(Cache::store('file'));
    }

    final function cacheExpiryInSeconds(): int
    {
        return 3600 * 6;
    }

    final function defaultBody(): array
    {
        $context = $this->agent->getContext();


        return [
            "messages" => [
                [
                    "role" => "system",
                    "content" => $this->agent->getInstructions()
                ],
                [
                    "role" => "user",
                    "content" => $context->summary
                ]
            ]
        ];
    }

    final function resolveEndpoint(): string
    {
        return 'ai/run/@cf/mistral/mistral-7b-instruct-v0.1';
    }


}
