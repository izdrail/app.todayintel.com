<?php
declare(strict_types=1);
namespace App\Contracts\Articles;

use Illuminate\Support\Collection;

interface FindArticlesContract
{
    public function findArticles(string $keyword): Collection;
}
