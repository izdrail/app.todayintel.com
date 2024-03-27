<?php

namespace Cornatul\Wordpress\WordpressRequests;
use Cornatul\Feeds\Models\Article;
use Illuminate\Support\Str;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Contracts\Body\HasBody;
use Saloon\Traits\Body\HasJsonBody;


class SearchPostRequest extends Request implements HasBody
{
    protected Method $method = Method::GET;

    use HasJsonBody;

    function __construct(protected readonly Article $article)
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
