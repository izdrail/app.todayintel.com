<?php
declare(strict_types=1);
namespace App\Jobs\Articles;

use App\Data\Models\Keyword;
use App\Saloon\Connectors\TodayIntelConnector;
use App\Saloon\Requests\Today\FindNewsRequest;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Lucid\Units\Job;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;


final class FindArticles extends Job
{
    public int $timeout = 90;

    public function __construct(
        public readonly string $keyword,
    )
    {
    }
    /**
     * @throws FatalRequestException
     * @throws RequestException
     * @throws \JsonException
     */
    final public function handle(): Collection
    {
        return $this->updateKeyword()->getNews($this->keyword);
    }

    private function updateKeyword(): self
    {
        Keyword::updateOrCreate(
            ['keyword' => $this->keyword],
            [
                'keyword' => $this->keyword,
                'count' => +1,
                'sentiment' => +1,
                'appeared_at' => Carbon::now(),
            ]
        );

        return $this;
    }

    /**
     * @throws FatalRequestException
     * @throws RequestException
     * @throws \JsonException
     */
    private function getNews(string $keyword): Collection
    {
        // Fetch today's news articles
        return (new TodayIntelConnector())
            ->send(new FindNewsRequest($keyword))
            ->collect('data')
            ->take(25);

    }
}
