<?php

namespace App\Data\Repositories;

use App\Data\DTO\ArticleDTO;
use App\Data\Models\Article;

final class ArticlesRepository
{
    final function createOrUpdate(ArticleDTO $articleDTO):Article
    {
        return Article::updateOrCreate([
            'link' => $articleDTO->link,
        ],[
            'title' => $articleDTO->title,
            'link' => $articleDTO->link,
            'status' => 'pending'
        ]);
    }
}
