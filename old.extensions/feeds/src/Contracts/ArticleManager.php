<?php
declare(strict_types=1);
namespace SaturnPHP\Feeds\Contracts;

use SaturnPHP\Feeds\DTO\ArticleDto;
use SaturnPHP\Feeds\DTO\FeedDto;

interface ArticleManager
{
    public function extract(string $url): ArticleDto;

}
