<?php
declare(strict_types=1);
namespace SaturnPHP\Intel\Contracts;

use Cornatul\Feeds\DTO\ArticleDto;
use Cornatul\Feeds\DTO\FeedDto;

interface ArticleManager
{
    public function extract(string $url): ArticleDto;


}
