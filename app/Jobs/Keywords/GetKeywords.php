<?php

namespace App\Jobs\Keywords;

use Illuminate\Support\Collection;
use JsonException;
use App\Saloon\Connectors\SafronConnector;
use App\Saloon\Connectors\TodayIntelConnector;
use App\Saloon\Requests\Safron\GetTrendingKeywords as GetSaffronTrendingKeywords;
use App\Saloon\Requests\Today\GetTrendingKeywords as GetsTodayIntelTrendingKeywords;
use Carbon\Carbon;
use Lucid\Units\Job;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;

class GetKeywords extends Job
{
    public int $timeout = 90;

    /**
     * @throws FatalRequestException
     * @throws RequestException|JsonException
     */
    final public function handle(): Collection
    {
        $safronKeywords = (new SafronConnector())->send(new GetSaffronTrendingKeywords())->collect()->get('results');

        $todayKeywords = (new TodayIntelConnector())->send(new GetsTodayIntelTrendingKeywords())->collect()->get('data');

        $mergedCollection = collect();

        $mergeKeywords = function ($collection) use ($mergedCollection) {
            $collection->each(function ($item) use ($mergedCollection) {
                $keyword = $item['keyword'];
                $count = $item['count'] ?? $item['appearance'] ?? 0;
                $sentiment_previous = $item['sentiment_previous'] ?? 0;
                $average_score = $item['average_score'] ?? 0;

                if ($mergedCollection->has($keyword)) {
                    $count += $mergedCollection->get($keyword)['count'];
                }

                $mergedCollection->put($keyword, [
                    'keyword' => $keyword,
                    'count' => $count,
                    'sentiment_previous' => $sentiment_previous,
                    'sentiment' => $sentiment_previous,
                    'average_score' => $average_score,
                    'appeared_at' => Carbon::today(),
                ]);
            });
        };

        $mergeKeywords(collect($safronKeywords));
        $mergeKeywords(collect($todayKeywords));

        return $mergedCollection->sortByDesc('count');


    }
}
