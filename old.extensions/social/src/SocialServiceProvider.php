<?php
declare(strict_types=1);

namespace Cornatul\Social;


use Cornatul\Social\Http\Controllers\SocialController;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Illuminate\Support\Facades\Route;
use Waterhole\Extend;
use Waterhole\Extend\CpNav;
use Waterhole\Extend\CpRoutes;
use Waterhole\View\Components\NavLink;

class SocialServiceProvider extends Extend\ServiceProvider
{
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'social');
    }

    final public function register(): void
    {
        $this->app->bind(
            ClientInterface::class,
            Client::class
        );

        //cms register
        $this->registerRoutes();
        $this->registerNav();
    }


    private function registerRoutes(): void
    {
        CpRoutes::add(function () {
            Route::get('social', SocialController::class . '@index')->name('social.index');
            Route::get('social/store', SocialController::class . '@store')->name('social.store');
        });
    }

    private function registerNav(): void
    {
        CpNav::add(
            fn() => new NavLink(
                label: __('Social'),
                icon: 'tabler-social',
                route: 'waterhole.cp.social.index',
            ),
            30,
            'social',
        );
    }
}
