<?php

namespace App\Providers;

use App\Contracts\GeneratorContract;
use App\Saloon\Connectors\CloudflareConnector;
use App\Service\Generators\GeneratorService;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Illuminate\Support\ServiceProvider;
use Waterhole\Extend\CpNav;
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
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {


//        CpRoutes::add(function () {
//            Route::get('trends', TrendsController::class . '@index')->name('trends.index');
//            Route::get('news', NewsController::class . '@index')->name('news.index');
//            Route::get('hacker', HackerNewsController::class . '@index')->name('hacker.index');
//            Route::get('chat', ChatController::class . '@index')->name('chat.index');
//            Route::post('chat', ChatController::class . '@process')->name('chat.process');
//            Route::get('article/{url}', ArticleController::class . '@index')->name('article.index');
//            Route::post('article/store', ArticleController::class . '@store')->name('article.store');
//            Route::post('api/save-all', ArticleController::class . '@saveAll')->name('article.saveAll');
//            Route::get('/topics/{topic?}', TopicsController::class . '@index')->name('topics.index');
//        });
    }
}
