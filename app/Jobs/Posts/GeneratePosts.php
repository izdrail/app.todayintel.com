<?php
declare(strict_types=1);
namespace App\Jobs\Posts;

use App\Agents\BlogAgent;
use App\Agents\GithubAgent;
use App\Agents\LinkedInAgent;
use App\Agents\TwitterAgent;
use App\Data\Models\Article;
use Illuminate\Contracts\Queue\ShouldQueue;
use Lucid\Units\Job;

/**
 * @todo replace this with LLpath
 */
final class GeneratePosts extends Job implements ShouldQueue
{

    public int $timeout = 90;

    public array $providers = [
        GithubAgent::class,
        LinkedInAgent::class,
        TwitterAgent::class,
        BlogAgent::class,
        BlogAgent::class,
    ];

    public function __construct(
        public readonly Article $article,
    )
    {

    }

    final public function handle():void
    {
        foreach ($this->providers as $provider) {
            $provider = app($provider, [
                'context' => $this->article
            ]);

            $provider->generate();
        }

    }
}
