<?php
declare(strict_types=1);
namespace SaturnPHP\Feeds\Repositories\Contracts;


use SaturnPHP\Feeds\DTO\FeedDto;
use SaturnPHP\Feeds\Models\Feed;
use Illuminate\Pagination\LengthAwarePaginator;
interface FeedRepositoryInterface
{
    public function createFeed(array $data): bool;
    public function deleteFeed(int $id): int;
    public function imported(string $url): bool;
    public function findFeed(string $column, string $value): Feed;
    public function listFeeds():  \Illuminate\Contracts\Pagination\LengthAwarePaginator;
    public function getFeed(int $id): Feed;
}
