<?php

namespace App\Saloon\Requests\WordpressRequests;
use Cornatul\Wordpress\DTO\WordpressPostDTO;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class CreatePostRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;


    public function __construct(protected  readonly  WordpressPostDTO $postDTO)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/posts';
    }
    protected final function defaultBody(): array
    {
        return [
            'title' => $this->postDTO->title,
            'content' => $this->postDTO->content,
            'excerpt' => $this->postDTO->excerpt,
            'status' => $this->postDTO->status,
            'categories' => $this->postDTO->categories,
            'tags' => $this->postDTO->tags,
        ];
    }

    protected function defaultHeaders(): array
    {
        return [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
    }


}
