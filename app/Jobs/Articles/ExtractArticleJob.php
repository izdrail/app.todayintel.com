<?php
declare(strict_types=1);
namespace App\Jobs\Articles;

use App\Data\DTO\ArticleDTO;
use App\Saloon\Connectors\TodayIntelConnector;
use App\Saloon\Requests\Today\ExtractArticleRequest;
use App\Data\Models\Article;

final class ExtractArticleJob
{
    public int $timeout = 90;

    public function __construct(
        public readonly Article $article,
    )
    {

    }

    final public function handle(): ArticleDTO
    {
        // Fetch extract
        $response =  (new TodayIntelConnector())
            ->send(new ExtractArticleRequest($this->article->url));

        $data = json_decode($response->body(), true) ?? [];

        return ArticleDTO::from([
            $data['data']
        ]);
    }
}
