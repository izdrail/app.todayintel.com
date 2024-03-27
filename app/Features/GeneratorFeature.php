<?php
declare(strict_types=1);
namespace App\Features;

use App\Data\Models\Article;
use App\Jobs\Posts\GeneratePosts;
use Lucid\Units\Feature;

final class GeneratorFeature extends Feature
{
    public function __construct(
        private readonly Article $article,
    )
    {
    }

    final public function handle(): mixed
    {
        return $this->run(
            new GeneratePosts($this->article)
        );
    }
}
