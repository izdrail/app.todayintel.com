<?php

declare(strict_types=1);

namespace App\Features\Articles;

use App\Data\DTO\KeywordDTO;
use App\Jobs\Keywords\GetKeywords;
use App\Jobs\Keywords\SaveKeywords;
use Illuminate\Support\Collection;
use Lucid\Units\Feature;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;

final class TrendingFeature extends Feature
{
    /**
     * @throws FatalRequestException
     * @throws RequestException
     * @throws \JsonException
     */
    final function handle(): Collection
    {
        $keywords = collect();

        foreach ((new GetKeywords())->handle() as $data) {
            $keywordDTO = KeywordDTO::from($data);
            $this->run(SaveKeywords::class, ['keywordDTO' => $keywordDTO]);
            $keywords->push($keywordDTO);
        }

        return $keywords;
    }

}
