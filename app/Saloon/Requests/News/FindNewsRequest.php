<?php

declare(strict_types=1);
namespace App\Saloon\Requests\News;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Saloon\CachePlugin\Contracts\Cacheable;
use Saloon\CachePlugin\Contracts\Driver;
use Saloon\CachePlugin\Drivers\LaravelCacheDriver;
use Saloon\CachePlugin\Traits\HasCaching;
use Saloon\Enums\Method;
use Saloon\Http\Request;


final class FindNewsRequest extends Request implements Cacheable
{
    use HasCaching;

    protected Method $method = Method::GET;


    public function __construct(private readonly string $keyword)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/everything';
    }

    final function defaultHeaders(): array
    {
        return [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
    }

    public function resolveCacheDriver(): Driver
    {
        return new LaravelCacheDriver(Cache::store('file'));
    }

    public function cacheExpiryInSeconds(): int
    {
        return 3600; // One Hour
    }

    protected function defaultQuery(): array
    {
        return [
            'apiKey' => config('services.news.api_key'),
            'q' => $this->keyword,
            'from' => Carbon::today()->subDays()->format('Y-m-d'),

        ];
    }

}
