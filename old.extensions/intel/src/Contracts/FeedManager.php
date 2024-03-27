<?php
declare(strict_types=1);
namespace SaturnPHP\Intel\Contracts;

use SaturnPHP\Intel\DTO\FeedDto;

interface FeedManager
{
    public function find(string $topic): FeedDto;
}
