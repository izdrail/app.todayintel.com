<?php

namespace App\Data\Repositories;

use App\Data\Models\Keyword;
use Illuminate\Support\Collection;

final class KeywordRepository
{
    final public function getLatestKeywords():Collection
    {
        return Keyword::with('articles')->where('updated_at', '>=', now()->subDay())->get();
    }
}
