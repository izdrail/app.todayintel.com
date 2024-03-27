<?php
declare(strict_types=1);
namespace App\Contracts\Articles;


use App\Data\Models\Article;

interface ExtractArticle
{
    public function extractArticle():  \App\Data\DTO\ArticleDTO;
}
