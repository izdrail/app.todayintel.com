<?php
declare(strict_types=1);

namespace SaturnPHP\Intel\Http\Controllers;



use SaturnPHP\Intel\Extractor\ExtractorInterface;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Waterhole\Http\Controllers\Controller;


class NewsController extends Controller
{

    public function __construct(protected readonly ExtractorInterface $extractor)
    {
    }

    public function index(Request $request): View
    {

        $news = $this->extractor->getNews($request->get('q'));

        return view('intel::news', [
            'keyword' => $request->get('q'),
            'news' => $news,
        ]);
    }
}
