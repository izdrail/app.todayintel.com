<?php
declare(strict_types=1);
namespace SaturnPHP\Intel\Extractor;

use Carbon\Carbon;
use SaturnPHP\Intel\DTO\ArticleDto;
use SaturnPHP\Intel\DTO\FeedDto;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Contracts\Cache\Repository as CacheInterface;
use Psr\SimpleCache\InvalidArgumentException;

/**
 * @todo Add caching to the API calls service , where key is the link and value is the response
 */
class ExtractorService implements ExtractorInterface
{

    public function __construct(private readonly ClientInterface $client, private readonly  CacheInterface $cache)
    {

    }

    /**
     * @throws GuzzleException
     * @throws InvalidArgumentException
     */
    final public function getArticle(string $link):ArticleDto
    {


        $cachedResponse = $this->cache->get($link);
        if ($cachedResponse !== null) {
            return $cachedResponse;
        }


        $response = $this->client->post(Config::get('intel.extract'), [
            'json' => [
                'link' => $link
            ],
        ]);

        if ($response->getStatusCode() !== 200) {
            throw new \RuntimeException('Error connecting to the API error code: ' .
                $response->getStatusCode());
        }

        $response =  json_decode($response->getBody()->getContents());


        if(!is_object($response)){
            throw new \RuntimeException('Error connecting to the API error code: ' .
                $response->getMessage());
        }

        $articleDto=  new ArticleDto(
            title: $response->data->title,
            link: $link,
            text: $response->data->text,
            html: $response->data->html,
            markdown: $response->data->markdown,
            spacy: $response->data->spacy,
            spacy_markdown: $response->data->spacy_markdown,
            keywords: $response->data->keywords,
            images: $response->data->images,
            entities: $response->data->entities,
            sentiment: $response->data->sentiment
        );

        // Cache the response for future use
        $this->cache->set($link, $articleDto);

        return $articleDto;
    }

    /**
     * @throws GuzzleException
     */

    final public function getTrends(): Collection
    {
        $cacheKey = 'trends_data';

        // Attempt to retrieve the data from the cache
        $cachedData = Cache::get($cacheKey);

        if ($cachedData !== null) {
            // If data exists in the cache, return the cached data
            return collect($cachedData);
        }

        // If data is not in the cache, make the API call
        $response = $this->client->get(Config::get('intel.trends'));

        if ($response->getStatusCode() !== 200) {
            throw new \RuntimeException('Error connecting to the API error code: ' .
                $response->getStatusCode() . ' ' .
                $response->getBody()->getContents()
            );
        }

        $responseData = json_decode($response->getBody()->getContents())->data;

        // Cache the API response for 6 hours
        Cache::put($cacheKey, $responseData, now()->addHours(6));

        return collect($responseData);
    }

    /**
     * @throws GuzzleException
     */
    final public function getNews(string $keyword): Collection
    {

        // Check if cached data exists for the given keyword
        if (Cache::has('news_' . $keyword)) {
            return Cache::get('news_' . $keyword);
        }

        $response = $this->client->post(Config::get('intel.news'), [
            'json' => [
                'topic' => $keyword
            ],
        ]);

        $response =  json_decode($response->getBody()->getContents());

        $collection = collect($response->data);

        $newsCollection = collect();

        $collection->each(function ($item) use ($newsCollection) {
            $array = (array)($item);
            $newsCollection->push([
                'title' => $array['title'],
                'url' => $array['url'],
                'date' => Carbon::parse($array['published date'])->format('d-m-Y H:i:s'),
            ]);
        });

        // Cache the results with a 6-hour expiration time
        Cache::put('news_' . $keyword, $newsCollection, now()->addHours(6));

        return $newsCollection->sort(function ($a, $b) {
            return $b['date'] <=> $a['date'];
        });
    }


    final public function getNewsByTopic(string $topic):Collection
    {
        // Check if cached data exists for the given keyword
        if (Cache::has('news_' . $topic)) {
            return Cache::get('news_' . $topic);
        }

        $response = $this->client->post(Config::get('intel.topic'), [
            'json' => [
                'topic' => $topic
            ],
        ]);

        if ($response->getStatusCode() !== 200) {
            throw new \RuntimeException('Error connecting to the API error code: ' .
                $response->getStatusCode() . ' ' .
                $response->getBody()->getContents()
            );
        }

        $response =  json_decode($response->getBody()->getContents());

        $collection = collect($response->data);

        $newsCollection = collect();

        $collection->each(function ($item) use ($newsCollection) {
            $array = (array)($item);
            $newsCollection->push([
                'title' => $array['title'],
                'url' => $array['url'],
                'date' => Carbon::parse($array['published date'])->format('d-m-Y H:i:s'),
            ]);
        });

        // Cache the results with a 6-hour expiration time
        Cache::put('news_' . $topic, $newsCollection, now()->addHours(6));

        return $newsCollection->sort(function ($a, $b) {
            return $b['date'] <=> $a['date'];
        });

    }



    final public function getHackerNewsByTopic(string $topic):Collection
    {
        if (Cache::has('hacker_' . $topic)) {
            return Cache::get('hacker_' . $topic);
        }

        $response = $this->client->get('https://hnrss.org/newest.jsonfeed?q=' . $topic);

        if ($response->getStatusCode() !== 200) {
            throw new \RuntimeException('Error connecting to the API error code: ' .
                $response->getStatusCode() . ' ' .
                $response->getBody()->getContents()
            );
        }

        $response =  json_decode($response->getBody()->getContents());

        $collection = collect($response->items);

        $newsCollection = collect();

        $collection->each(function ($item) use ($newsCollection) {
            $array = (array)($item);
            $newsCollection->push([
                'title' => $array['title'],
                'url' => $array['url'],
                'date' => Carbon::parse($array['date_published'])->format('d-m-Y H:i:s'),
            ]);
        });

        // Cache the results with a 6-hour expiration time
        Cache::put('hacker_' . $topic, $newsCollection, now()->addHours(6));

        return $newsCollection->sort(function ($a, $b) {
            return $b['date'] <=> $a['date'];
        });


    }


    final public function find(string $topic): FeedDto
    {
        $response = $this->client->post(Config::get('intel.find'), [
            'json' => [
                'keyword' => $topic
            ],
        ]);

        if ($response->getStatusCode() !== 200) {
            throw new \RuntimeException('Error connecting to the API error code: ' .
                $response->getStatusCode() . ' ' .
                $response->getBody()->getContents()
            );
        }

        $response =  json_decode($response->getBody()->getContents());

        $collection = collect($response->data);

        $newsCollection = collect();

        $collection->each(function ($item) use ($newsCollection) {
            $array = (array)($item);
            $newsCollection->push([
                'title' => $array['title'],
                'url' => $array['url'],
                'date' => Carbon::parse($array['published date'])->format('d-m-Y H:i:s'),
            ]);
        });

        // Cache the results with a 6-hour expiration time
        Cache::put('news_' . $topic, $newsCollection, now()->addHours(6));

        return FeedDto::from($collection);
    }
}
