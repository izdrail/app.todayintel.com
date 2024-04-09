<?php
declare(strict_types=1);
namespace App\Saloon\Requests\Today;
use App\Data\DTO\ArticleDTO;
use App\Data\Repositories\ArticlesRepository;
use Illuminate\Support\Facades\Cache;
use Saloon\CachePlugin\Contracts\Cacheable;
use Saloon\CachePlugin\Contracts\Driver;
use Saloon\CachePlugin\Drivers\LaravelCacheDriver;
use Saloon\CachePlugin\Traits\HasCaching;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;
use Saloon\Http\Response;


final class ExtractArticleRequest extends Request implements Cacheable, HasBody
{
    use HasCaching;
    use HasJsonBody;
    protected Method $method = Method::POST;


    public function __construct(private readonly string $url)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/nlp/article';
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
            'link' => $this->url,
        ];
    }

    /**
     * @throws \JsonException
     */
    public function createDtoFromResponse($response): ArticleDTO
    {
        $data = $response->json()['data'];

        $dto =  new ArticleDTO(
            $data['title'],
            $this->url,
            'processed',
            $data['summary'],
            $data['text'],
            $data['html'],
            $data['markdown'],
            $data['spacy'],
            $data['spacy_markdown'],
            $data['keywords'],
            $data['images'],
            $data['entities'],
            $data['sentiment']
        );

        //save to a database
          $repository = new ArticlesRepository();
          $repository->createOrUpdate($dto);

         return $dto;
    }
}
