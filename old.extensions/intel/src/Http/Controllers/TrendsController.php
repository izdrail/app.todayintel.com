<?php
declare(strict_types=1);

namespace SaturnPHP\Intel\Http\Controllers;


use SaturnPHP\Intel\Extractor\ExtractorInterface;
use Illuminate\View\View;
use Waterhole\Http\Controllers\Controller;


class TrendsController extends Controller
{

    public function __construct(protected readonly ExtractorInterface $extractor)
    {

    }

    final public function index(): View
    {
        return view('intel::trends', [
            'keywords' => $this->extractor->getTrends()->sort(),
        ]);
    }
}
