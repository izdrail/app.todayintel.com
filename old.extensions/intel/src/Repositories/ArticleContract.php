<?php

namespace SaturnPHP\Intel\Repositories;

use SaturnPHP\Intel\DTO\ArticleDto;
use SaturnPHP\Intel\Models\Article;

interface ArticleContract
{
    public function create(ArticleDto $article, int $link_id): Article;
}
