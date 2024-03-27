<?php

namespace Cornatul\Websites;

use Cornatul\Websites\Http\Controllers\WebsitesController;
use Illuminate\Support\Facades\Route;
use Waterhole\Extend;
use Waterhole\Extend\CpNav;
use Waterhole\Extend\CpRoutes;
use Waterhole\View\Components\NavLink;

class WebsitesServiceProvider extends Extend\ServiceProvider
{
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'websites');
    }

    final public function register(): void
    {

        $this->app->bind(
            Repositories\WebsiteRepositoryInterface::class,
            Repositories\WebsiteRepository::class,
        );

        //cms register
        $this->registerRoutes();
        $this->registerNav();
    }

    private function registerRoutes(): void
    {
        CpRoutes::add(function () {
            Route::get('websites', WebsitesController::class . '@index')->name('websites.index');
            Route::get('websites/create', WebsitesController::class . '@create')->name('websites.create');
            Route::post('websites/store', WebsitesController::class . '@store')->name('websites.store');
        });
    }

    private function registerNav(): void
    {
        CpNav::add(
            fn() => new NavLink(
                label: __('Websites'),
                icon: 'tabler-websites',
                route: 'waterhole.cp.websites.index',
            ),
            30,
            'websites',
        );
    }
}
