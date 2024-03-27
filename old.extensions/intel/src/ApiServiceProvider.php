<?php
declare(strict_types=1);

namespace SaturnPHP\Intel;





use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Waterhole\Extend;
use Illuminate\Support\Facades\Route;
use Waterhole\Extend\CpNav;
use Waterhole\Extend\CpRoutes;
use Waterhole\View\Components\NavLink;


class ApiServiceProvider extends Extend\ServiceProvider
{
    public function boot(): void
    {
    }

    final public function register(): void
    {
    }

}
