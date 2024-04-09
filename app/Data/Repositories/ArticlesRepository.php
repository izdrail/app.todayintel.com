<?php

namespace App\Data\Repositories;

use App\Data\DTO\ArticleDTO;
use App\Data\Models\Article;
use App\Data\Models\Post;
use Illuminate\Support\Str;
use Waterhole\Models\Channel;

final class ArticlesRepository
{
    final function createOrUpdate(ArticleDTO $articleDTO):Article
    {
        $this->createPost($articleDTO);
        return Article::updateOrCreate([
            'link' => $articleDTO->link,
        ],[
            'title' => $articleDTO->title,
            'status' => $articleDTO->status,
            'link' => $articleDTO->link,
             'body' => $articleDTO->markdown,
             'summary' => $articleDTO->summary,
             'images' => $articleDTO->images,
             'keywords' => $articleDTO->keywords,
             'sentiment' => $articleDTO->sentiment,
         ]);
    }

    private function createPost(ArticleDTO $articleDTO)
    {
        return Post::updateOrCreate([
            'title' => $articleDTO->title,
            'channel_id' => ($this->createChannel($articleDTO))->id
        ], [
             'body' => $articleDTO->markdown,
         ]);
    }

    private function createChannel(ArticleDTO $articleDTO) :Channel
    {
         return Channel::updateOrCreate([
             'name' => $articleDTO->title
         ], [
             'slug' => Str::slug($articleDTO->title),
          ]);
    }

}
