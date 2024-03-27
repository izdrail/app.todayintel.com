<?php

namespace SaturnPHP\Intel\Repositories;


use SaturnPHP\Intel\Models\Link;

/**
 * Class ArticleRepository
 * @package Cornatul\Intel\Repositories
 */
interface LinkContract
{
    public function create(array $data): Link;
    public function find(string $url): ?Link;
}
