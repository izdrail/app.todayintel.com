<?php
declare(strict_types=1);
namespace SaturnPHP\Feeds\Contracts;

use SaturnPHP\Feeds\DTO\FeedDto;

interface FeedManager
{
    public function find(string $topic): FeedDto;
}
