<?php
declare(strict_types=1);

namespace App\Features\Articles;

use App\Data\DTO\ArticleDTO;
use App\Data\DTO\KeywordDTO;
use App\Jobs\Articles\ExtractArticleJob;
use App\Jobs\Articles\FindArticles;
use App\Jobs\Keywords\GetKeywords;
use App\Jobs\Keywords\SaveKeywords;
use Illuminate\Support\Collection;
use Lucid\Units\Feature;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;


final class ArticlesFeature extends Feature
{

    public function __construct(private readonly KeywordDTO $keyword)
    {

    }

    //todo return an collection of articles

    /**
     * @throws FatalRequestException
     * @throws RequestException
     * @throws \JsonException
     */
    final function handle(): Collection
    {
        $results = collect();

        foreach ((new FindArticles($this->keyword))->handle() as $data) {

            $data['link']  = $data['url'];
            $data['text'] = $data['description'];
            $data['status'] =  'pending';

            $articleDTO = ArticleDTO::from($data);

            $response = $this->run(new ExtractArticleJob($articleDTO));

            $results->push($response);

        }

        return $results;
    }

}
