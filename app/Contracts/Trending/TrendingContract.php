<?php
declare(strict_types=1);
namespace App\Contracts\Trending;
use Illuminate\Support\Collection;


interface TrendingContract
{
    public function getTrendingKeywords(): Collection;
}
