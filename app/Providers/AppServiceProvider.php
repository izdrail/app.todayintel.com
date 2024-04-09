<?php

namespace App\Providers;

use App\Contracts\GeneratorContract;
use App\Http\Controllers\Trends\TrendsController;
use App\Saloon\Connectors\CloudflareConnector;
use App\Service\Generators\GeneratorService;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Illuminate\Routing\Route;
use Illuminate\Support\ServiceProvider;
use SaturnPHP\Intel\Http\Controllers\ArticleController;
use SaturnPHP\Intel\Http\Controllers\ChatController;
use SaturnPHP\Intel\Http\Controllers\HackerNewsController;
use SaturnPHP\Intel\Http\Controllers\NewsController;
use SaturnPHP\Intel\Http\Controllers\TopicsController;
use Waterhole\Extend\CpNav;
use Waterhole\Extend\CpRoutes;
use Waterhole\View\Components\NavLink;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    final function register(): void
    {
        //
        $this->app->bind(ClientInterface::class, function () {
            return new Client();
        });

        $this->app->bind(GeneratorContract::class, function () {
            return new GeneratorService(new CloudflareConnector);
        });

        CpNav::add(
            fn() => new NavLink(
                label: __('Trending'),
                icon: 'tabler-trending-up',
                route: 'trending.index',
            ),
            20,
            'trends',
        );

        CpNav::add(
            fn() => new NavLink(
                label: __('News'),
                icon: 'tabler-trending-up',
                route: 'news.index',
            ),
            20,
            'news',
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

    }
}

