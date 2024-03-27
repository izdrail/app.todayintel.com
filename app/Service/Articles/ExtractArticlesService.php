<?php

declare(strict_types=1);

namespace App\Service\Articles;


use App\Contracts\Articles\ExtractArticle;
use App\Data\DTO\ArticleDTO;
use App\Data\Models\Article;
use Lucid\Units\Feature;
use  \App\Jobs\Articles\ExtractArticleJob;;
final class ExtractArticlesService extends Feature implements ExtractArticle
{

    public function __construct(
        private readonly Article $article
    )
    {
    }

    public function handle(): ArticleDTO
    {
       return $this->extractArticle();
    }

    public function extractArticle(): ArticleDTO
    {
        $data =  ((new ExtractArticleJob($this->article))->handle());
        logger(json_encode($data));
        return $data;
    }
}
