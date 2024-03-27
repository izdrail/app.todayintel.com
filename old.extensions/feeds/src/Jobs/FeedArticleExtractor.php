<?php
declare(strict_types=1);
namespace SaturnPHP\Feeds\Jobs;


use SaturnPHP\Feeds\Models\Feed;
use GuzzleHttp\ClientInterface;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;

use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Throwable;
use SaturnPHP\Feeds\DTO\ArticleDto;

/**
 * @package UnixDevil\Crawler\Jobs
 * @class FeedCrawlerJob
 *
 */


class FeedArticleExtractor implements ShouldQueue
{
    //todo move this to client request using saloon
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;
    private string $url;

    private Feed $feed;

    public int $tries = 1;

    public function __construct(string $url, Feed $feed)
    {
        $this->feed = $feed;
        $this->url = $url;
    }

    /**
     * @throws Throwable
     */
    final public function handle(ClientInterface $client): ArticleDto
    {
        try {
            //TODO Rewrite to use the nlp client instead of the reader
            $response = $client->post(config('feeds.nlp-api-url'). 'article', [
                'json' => [
                    'link' => $this->url
                ]
            ]);

            $collection = collect(
                json_decode(
                    $response->getBody()->getContents(),
                    false,
                    512,
                    JSON_THROW_ON_ERROR
                )
            );

            $dto = ArticleDto::from($collection->get('data'));

            dispatch(new SaveArticle($dto, $this->feed, $this->url))->onQueue('save-article');

            return $dto;

        } catch (\Exception $exception) {
            info("Something went wrong trying to extract the $this->url");
            info($exception->getLine());
            info($exception->getMessage());
            info($exception->getTraceAsString());
        }



        return ArticleDto::from([]);

    }

    final public function failed($exception = null): void
    {
        $this->delete();
    }
}
