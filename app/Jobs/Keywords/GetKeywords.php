<?php

namespace App\Jobs\Keywords;

use App\Saloon\Connectors\HackerNewsConnector;
use App\Saloon\Requests\HackerNews\FindHackerNewsRequest;
use Illuminate\Support\Collection;
use JsonException;
use App\Saloon\Connectors\SafronConnector;
use App\Saloon\Connectors\TodayIntelConnector;
use App\Saloon\Requests\Safron\GetTrendingKeywords as GetSaffronTrendingKeywords;
use App\Saloon\Requests\Today\GetTrendingKeywords as GetTodayIntelTrendingKeywords;
use Carbon\Carbon;
use Lucid\Units\Job;
use Saloon\Exceptions\InvalidResponseClassException;
use Saloon\Exceptions\PendingRequestException;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\Connector;
use Saloon\Http\Request;

class GetKeywords extends Job
{
    public int $timeout = 90;

    /**
     * Fetch trending keywords from Safron and TodayIntel connectors,
     * merge them, and return a sorted collection.
     *
     * @return Collection
     * @throws FatalRequestException
     * @throws RequestException
     * @throws JsonException
     */
    final public function handle(): Collection
    {
        $safronKeywords = $this->fetchKeywords(new SafronConnector(), new GetSaffronTrendingKeywords(), 'results');
        $todayKeywords = $this->fetchKeywords(new TodayIntelConnector(), new GetTodayIntelTrendingKeywords(), 'data');


        $mergedCollection = $this->mergeCollections($safronKeywords, $todayKeywords);

        return $mergedCollection->sortByDesc('count');
    }

    /**
     * Fetch keywords from the specified connector and request,
     * and return a collection.
     *
     * @param Connector $connector
     * @param Request $request
     * @param string $key
     * @return Collection
     * @throws FatalRequestException
     * @throws RequestException
     * @throws \ReflectionException
     * @throws InvalidResponseClassException
     * @throws PendingRequestException
     * @throws JsonException
     */
    private function fetchKeywords(Connector $connector, Request $request, string $key): Collection
    {
        return collect($connector->send($request)->collect()->get($key));
    }

    /**
     * Merge two collections of keywords.
     *
     * @param Collection $collection1
     * @param Collection $collection2
     * @return Collection
     */
    private function mergeCollections(Collection $collection1, Collection $collection2): Collection
    {
        $mergedCollection = collect();

        $mergeKeywords = function ($collection) use ($mergedCollection) {
            $collection->each(function ($item) use ($mergedCollection) {
                $keyword = $item['keyword'];
                $count = $item['count'] ?? $item['appearance'] ?? 0;
                $sentiment_previous = $item['sentiment_previous'] ?? [];
                $average_score = $item['average_score'] ?? [];

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

        $mergeKeywords($collection1);
        $mergeKeywords($collection2);

        return $mergedCollection;
    }
}
