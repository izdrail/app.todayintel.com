<?php
declare(strict_types=1);

namespace SaturnPHP\Intel\Http\Controllers;


use SaturnPHP\Intel\Extractor\ExtractorInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\View\View;
use Waterhole\Http\Controllers\Controller;


class HackerNewsController extends Controller
{

    public function __construct(protected readonly ExtractorInterface $extractor)
    {

    }

    final public function index(Request $request): \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
    {
        return view('intel::hacker', [
            'keyword' => $request->get('q'),
            'news' => []
        ]);

    }


    final public function api(Request $request): JsonResource
    {
        $news = $this->extractor->getHackerNewsByTopic($request->get('keyword') ?? 'laravel');

        return new JsonResource([
            'keyword' => $request->get('keyword'),
            'news' => $news,
        ]);

    }
}
