<?php
declare(strict_types=1);

namespace SaturnPHP\Intel;




use App\Http\Controllers\API\ApiController;
use SaturnPHP\Intel\Clients\FeedlyClient;
use SaturnPHP\Intel\Contracts\FeedManager;
use SaturnPHP\Intel\Crud\CrudInterface;
use SaturnPHP\Intel\Extractor\ExtractorInterface;
use SaturnPHP\Intel\Extractor\ExtractorService;
use SaturnPHP\Intel\Http\Controllers\ArticleController;
use SaturnPHP\Intel\Http\Controllers\ChatController;
use SaturnPHP\Intel\Http\Controllers\HackerNewsController;
use SaturnPHP\Intel\Http\Controllers\NewsController;
use SaturnPHP\Intel\Http\Controllers\TopicsController;
use SaturnPHP\Intel\Http\Controllers\TrendsController;
use SaturnPHP\Intel\Repositories\ArticleContract;
use SaturnPHP\Intel\Repositories\LinkContract;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Waterhole\Extend;
use Illuminate\Support\Facades\Route;
use Waterhole\Extend\CpNav;
use Waterhole\Extend\CpRoutes;
use Waterhole\View\Components\NavLink;


class IntelServiceProvider extends Extend\ServiceProvider
{
    public function boot(): void
    {


        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'intel');
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'intel');


        $this->publishes([
            __DIR__.'/../config/intel.php' => config_path('intel.php'),
        ], 'config');

        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->loadViewComponentsAs('intel', [
            NavLink::class,
        ]);

    }

    final public function register(): void
    {


        $this->app->bind(
            ExtractorInterface::class,
            ExtractorService::class
        );

        $this->app->bind(
            ClientInterface::class,
            Client::class
        );

        $this->app->bind(
            CrudInterface::class,
            SaturnPHP\Intel\Crud\CrudService::class
        );

        $this->app->bind(
            ArticleContract::class,
            SaturnPHP\Intel\Repositories\ArticleRepository::class
        );

        $this->app->bind(
            LinkContract::class,
            SaturnPHP\Intel\Repositories\LinkRepository::class
        );

        $this->app->bind(
            FeedManager::class,
            FeedlyClient::class
        );



        //cms register
        $this->registerRoutes();
        $this->registerNav();

        //Extend\Script::add(asset('js/chat.js'), bundle: 'cp');

    }



    private function registerRoutes(): void
    {

    }

    private function registerNav(): void
    {
        CpNav::add(
            fn() => new NavLink(
                label: __('Google Trends'),
                icon: 'tabler-trending-up',
                route: 'waterhole.cp.trends.index',
            ),
            20,
            'trends',
        );

        CpNav::add(
            fn() => new NavLink(
                label: __('Topics'),
                icon: 'tabler-presentation-analytics',
                route: 'waterhole.cp.topics.index',
            ),
            20,
            'topics',
        );


        CpNav::add(
            fn() => new NavLink(
                label: __('Hacker News'),
                icon: 'tabler-news',
                route: 'waterhole.cp.hacker.index',
            ),
            10,
            'hacker',
        );


        CpNav::add(
            fn() => new NavLink(
                label: __('AI Rewriter'),
                icon: 'tabler-chat',
                route: 'waterhole.cp.chat.index',
            ),
            10,
            'chat',
        );
    }

}
