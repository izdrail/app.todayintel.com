<?php

namespace SaturnPHP\Intel\Extractor;

use SaturnPHP\Intel\DTO\ArticleDto;
use Illuminate\Support\Collection;
use SaturnPHP\Intel\Contracts\FeedManager;
/**
 * Interface ExtractorInterface
 * @package Cornatul\Intel\Extractor\Interfaces
 */
interface ExtractorInterface extends FeedManager
{
    public function getArticle(string $link): ArticleDto;

    public function getTrends(): Collection;

    public function getNews(string $keyword): Collection;

    public function getNewsByTopic(string $topic): Collection;

    public function getHackerNewsByTopic(string $topic): Collection;
}
