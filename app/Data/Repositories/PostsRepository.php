<?php

namespace App\Data\Repositories;

use App\Data\DTO\ArticleDTO;
use App\Data\Models\Article;
use App\Data\Models\Post;

final class PostsRepository
{
    final function createOrUpdate(ArticleDTO $articleDTO):Article
    {
        //['title', 'status','body', 'summary', 'link' , 'images', 'keywords', 'sentiment']
        return Post::updateOrCreate([
            'link' => $articleDTO->link,
        ],[
            'title' => $articleDTO->title,
            'link' => $articleDTO->link,
             'body' => $articleDTO->text,
             'summary' => $articleDTO->summary,
             'images' => $articleDTO->images,
             'keywords' => $articleDTO->keywords,
             'sentiment' => $articleDTO->sentiment,
         ]);
    }
}
