<?php

declare(strict_types=1);

namespace App\Features\Wordpress;

use App\Data\DTO\KeywordDTO;
use App\Data\Models\Article;
use App\Jobs\Keywords\GetKeywords;
use App\Jobs\Keywords\SaveKeywords;
use App\Saloon\Connectors\WordpressConnector;
use Illuminate\Support\Collection;
use Lucid\Units\Feature;

final class CreateWordpressPostFeature extends Feature
{
    final function handle(): Collection
    {
        $article = Article::find(1);

        $wordpress = new WordpressConnector(config('wordpress'));

        return collect([]);
    }

}
