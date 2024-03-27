<?php

namespace SaturnPHP\Intel\Repositories;


use SaturnPHP\Intel\Models\Article;
use SaturnPHP\Intel\DTO\ArticleDto;
use SaturnPHP\Intel\Models\Link;

/**
 * Class ArticleRepository
 * @package Cornatul\Intel\Repositories
 */
class LinkRepository implements LinkContract
{

    final public function create(array $data): Link
    {
        return (new Link())->create($data);
    }

    final public function find(string $url): ?Link
    {
        return (new Link())->where('link', $url)->first();
    }
}
