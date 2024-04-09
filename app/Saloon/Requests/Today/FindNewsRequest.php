<?php
declare(strict_types=1);
namespace App\Saloon\Requests\Today;
use App\Data\DTO\KeywordDTO;
use Illuminate\Support\Facades\Cache;
use Saloon\CachePlugin\Contracts\Cacheable;
use Saloon\CachePlugin\Contracts\Driver;
use Saloon\CachePlugin\Drivers\LaravelCacheDriver;
use Saloon\CachePlugin\Traits\HasCaching;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;


final class FindNewsRequest extends Request implements Cacheable,HasBody
{
    use HasCaching;

    use HasJsonBody;


    protected Method $method = Method::POST;


    public function __construct(private readonly KeywordDTO $keyword)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/google/news/search';
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
        //increase to 6 hours
        return 21600;
    }

    final function defaultBody(): array
    {
        return [
            'topic' => $this->keyword->keyword,
        ];
    }

}
