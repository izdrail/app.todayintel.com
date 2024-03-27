<?php
declare(strict_types=1);

namespace App\Features\Articles;

use App\Data\DTO\KeywordDTO;
use App\Jobs\Keywords\GetKeywords;
use App\Jobs\Keywords\SaveKeywords;
use App\Saloon\Connectors\SafronConnector;
use App\Saloon\Connectors\TodayIntelConnector;
use App\Saloon\Requests\Safron\GetTrendingKeywords as GetSaffronTrendingKeywords;
use App\Saloon\Requests\Today\GetTrendingKeywords as GetsTodayIntelTrendingKeywords;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Lucid\Units\Feature;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;



final class TrendingFeature extends Feature
{

    /**
     */
    final public function handle():Collection
    {

       $keywords = collect();

        foreach ($this->getKeywords() as $data) {

            $keywordDTO = KeywordDTO::from($data);

            $this->run(SaveKeywords::class, [
                'keywordDTO' => $keywordDTO
            ]);

            $keywords->push(
                $keywordDTO
            );
        }

        return $keywords->sortByDesc(function ($item) {

            return $item['sentiment']['positive']['average_score'];
        });
    }


    /**
     */
    final public function getKeywords(): Collection
    {

        $getKeywords = new GetKeywords();

        try {
            return $getKeywords->handle();
        } catch (\JsonException|FatalRequestException|RequestException $e) {
            logger($e->getMessage());
        }

        return collect();
    }
}
