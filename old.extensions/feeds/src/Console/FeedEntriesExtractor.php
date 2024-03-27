<?php
declare(strict_types=1);
namespace SaturnPHP\Feeds\Console;


use SaturnPHP\Feeds\Jobs\FeedArticleExtractor;
use SaturnPHP\Feeds\Models\Feed;
use SaturnPHP\Feeds\Requests\FeedlyTopicRequest;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Laminas\Feed\Reader\Reader;
use Saloon\Exceptions\InvalidResponseClassException;
use Saloon\Exceptions\PendingRequestException;

class FeedEntriesExtractor extends Command
{

    protected $signature = 'feed:extract {url}';

    protected $description = 'Extract the full list of articles from a given feed';

    /**
     * @throws \ReflectionException
     * @throws InvalidResponseClassException
     * @throws PendingRequestException
     * @throws \JsonException
     */
    public function handle(): void
    {
        $url = $this->argument('url');

        $client = new FeedLaminasClient();

        Reader::setHttpClient($client);

        $data = Reader::import($url);

        $feed = Feed::first();

        foreach ($data as $entity)
        {
            dispatch(new FeedArticleExtractor($entity->getLink(), $feed))->onQueue('article-extractor');
        }

    }
}
