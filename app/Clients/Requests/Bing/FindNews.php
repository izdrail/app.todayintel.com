<?php

namespace App\Clients\Requests\Bing;

//https://www.bing.com/news/search?format=RSS&q=laravel
class FindNews
{

    public function __construct(private readonly string $keyword)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/news/search';
    }
}
