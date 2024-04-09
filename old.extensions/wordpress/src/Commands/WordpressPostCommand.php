<?php
declare(strict_types=1);

namespace Cornatul\Wordpress\Commands;

use App\Clients\WordpressRestClient;
use Cornatul\Feeds\Models\Article;
use Cornatul\Wordpress\Jobs\WordpressRestPostCreator;
use Cornatul\Wordpress\Models\WordpressWebsite;
use Cornatul\Wordpress\Services\Rest\WordpressPostRestService;
use Illuminate\Console\Command;

class WordpressPostCommand extends Command
{
    protected $signature = 'wordpress:post';

    protected $description = 'This command will post a selected article to wordpress';

    public function __construct(
        private readonly Collection $articles,
        private readonly WordpressWebsite $wordpressWebsite,
        private readonly WordpressRestPostCreator $wordpressRestPostCreator
    ) {
        parent::__construct();
    }

    /**
     * @throws \RuntimeException
     */
    public function handle(): void
    {
        $dispatchedJobs = new Collection();

        /** @var Article $article */
        foreach ($this->articles as $article) {
            try {
                info('Posting article ' . $article->id . ' to Wordpress');

                $this->wordpressRestPostCreator->handle(
                    new WordpressRestClient($article, $this->wordpressWebsite)
                );

                $dispatchedJobs->push($article);
            } catch (\RuntimeException $exception) {
                $this->error('Failed to dispatch job: ' . $exception->getMessage());
            }
        }

        $this->info('Posted ' . $dispatchedJobs->count() . ' articles to Wordpress');
    }
}
