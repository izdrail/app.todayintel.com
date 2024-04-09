<?php

namespace App\Console\Commands;

use App\Data\Models\Article;
use App\Features\Articles\ArticlesFeature;
use App\Features\Articles\TrendingFeature;
use App\Saloon\Connectors\TodayIntelConnector;
use App\Saloon\Requests\Today\ExtractArticleRequest;
use App\Saloon\Requests\Today\FindNewsRequest;
use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;
use Waterhole\Models\User;

final class ArticleExtractor extends Command
{

    protected $signature = 'articles:extract';

    protected $description = 'Extracts articles for the latest keywords found';


    public function __construct()
    {
         parent::__construct();
    }


    public function handle():void
    {
        $keywords = ( new TrendingFeature())->handle()->take(500);

        $keywords->each(function($keyword) {

            $articles  = (new ArticlesFeature($keyword))->handle();

            $this->info(sprintf('Extracting articles for keyword "%s articles found:(%s)"', $keyword->keyword, $articles->count()));

        });

    }

}
