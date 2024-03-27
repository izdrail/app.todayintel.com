<?php
declare(strict_types=1);

namespace App\Http\Controllers\Trends;


use App\Features\Articles\TrendingFeature;
use Illuminate\View\View;
use Waterhole\Http\Controllers\Controller;


class TrendsController extends Controller
{

    public function index():View
    {
        $keywords = ( new TrendingFeature())->getKeywords()->take(50);

        return view('cp.trending.index', compact('keywords'));
    }
}
