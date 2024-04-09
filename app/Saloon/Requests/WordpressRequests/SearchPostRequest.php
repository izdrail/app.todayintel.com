<?php

namespace App\Saloon\Requests\WordpressRequests;
use App\Data\DTO\ArticleDTO;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;


class SearchPostRequest extends Request implements HasBody
{
    protected Method $method = Method::GET;

    use HasJsonBody;

    function __construct(protected readonly ArticleDTO $article)
    {

    }

    public final function resolveEndpoint(): string
    {
        return '/posts';
    }

    protected function defaultQuery(): array
    {
        return [
            'search' => $this->article->title,
        ];
    }
}
