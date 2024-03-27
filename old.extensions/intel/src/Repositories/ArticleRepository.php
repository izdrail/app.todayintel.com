<?php

namespace SaturnPHP\Intel\Repositories;


use SaturnPHP\Intel\Models\Article;
use SaturnPHP\Intel\DTO\ArticleDto;

/**
 * Class ArticleRepository
 * @package Cornatul\Intel\Repositories
 */
class ArticleRepository implements ArticleContract
{

    final public function create(ArticleDto $article, int $link_id): Article
    {
        return (new Article())->create([
            'title' => $article->title,
            'link_id' => $link_id,
            'text' => $article->text,
            'html' => $article->html,
            'markdown' => $article->markdown,
            'spacy' => $article->spacy,
            'spacy_markdown' => $article->spacy_markdown,
            'keywords' => $article->keywords,
            'images' => $article->images,
            'entities' => $article->entities,
        ]);
    }
}
