<?php
declare(strict_types=1);
namespace SaturnPHP\Feeds;

use SaturnPHP\Feeds\Clients\FeedlyClient;
use SaturnPHP\Feeds\Console\ArticleExtractorCommand;
use SaturnPHP\Feeds\Console\FeedEntriesExtractor;
use SaturnPHP\Feeds\Contracts\FeedManager;
use SaturnPHP\Feeds\Repositories\Contracts\ArticleRepositoryInterface;
use SaturnPHP\Feeds\Contracts\FeedFinderInterface;
use SaturnPHP\Feeds\Repositories\ArticleEloquentRepository;
use SaturnPHP\Feeds\Repositories\FeedRepository;
use SaturnPHP\Feeds\Repositories\Contracts\FeedRepositoryInterface;
use SaturnPHP\Feeds\Repositories\Contracts\SortableInterface;
use SaturnPHP\Feeds\Services\SortableService;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class FeedsServiceProvider extends ServiceProvider
{
    final public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'feeds');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadRoutesFrom(__DIR__.'/../routes/feed.php');
        $this->publishes([
            __DIR__ . '/../config/config.php' => config_path('feeds.php'),
        ], 'feeds-config');

        if ($this->app->runningInConsole()) {

            $this->publishes([
                __DIR__ . '/../config/config.php' => config_path('feeds.php'),
            ], 'feeds-config');

            $this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/feeds'),
            ], 'feeds-views');

            $this->publishes([
                __DIR__.'/../routes/' => \config_path('../routes/feeds'),
            ], 'feeds-routes');

            $this->publishes([
                __DIR__.'/../database/migrations/' => \config_path('../database/migrations/'),
            ], 'feeds-migrations');


            $this->commands([
                ArticleExtractorCommand::class,
                FeedEntriesExtractor::class
            ]);

        }
    }

    final public function register(): void
    {
        $this->app->bind(ClientInterface::class, Client::class);
        //todo move this to a system server manager class  and use a system provider for every social provider
        //@todo -> The provider should be able to register the social client and return a social client instance response that contais the feed dto , this can be a any response from rss clients which are contained into a docker server that is running on the system gateway.
        $this->app->bind(FeedManager::class, FeedlyClient::class);




        $this->app->bind(FeedRepositoryInterface::class, FeedRepository::class);
        $this->app->bind(ArticleRepositoryInterface::class, ArticleEloquentRepository::class);
        $this->app->bind(SortableInterface::class, SortableService::class);

    }

}
