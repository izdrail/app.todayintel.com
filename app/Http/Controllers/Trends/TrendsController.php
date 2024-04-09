<?php
declare(strict_types=1);

namespace App\Http\Controllers\Trends;


use App\Features\Articles\TrendingFeature;
use App\Filament\Widgets\TrendingKeywords;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Waterhole\Http\Controllers\Controller;


class TrendsController extends Controller
{

    /**
     * @throws FatalRequestException
     * @throws RequestException
     * @throws \JsonException
     */
    final function index(): Factory|View|Application
    {
        $keywords = ( new TrendingFeature())->handle()->take(5000);

        return view('cp.trending.index', compact('keywords', ));
    }
}
