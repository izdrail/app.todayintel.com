<?php
declare(strict_types=1);

namespace SaturnPHP\Intel\Http\Controllers;



use SaturnPHP\Intel\Crud\CrudInterface;
use SaturnPHP\Intel\Extractor\ExtractorInterface;
use SaturnPHP\Intel\Http\Requests\CreatePostRequest;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Waterhole\Http\Controllers\Controller;
use Waterhole\Models\Channel;
use Waterhole\Models\Post;

/**
 * Class ArticleController
 */
class TopicsController extends Controller
{

    public function __construct(protected readonly ExtractorInterface $extractor)
    {
        //authorize
    }

    final public function index(string $topic = 'WORLD'): View
    {

        return view('intel::topics', [
            'topic' => $topic,
            //todo move this to channels
            'topics' => [
                'WORLD',
                'NATION',
                'BUSINESS',
                'TECHNOLOGY',
                'ENTERTAINMENT',
                'SPORTS',
                'SCIENCE',
                'HEALTH',
            ],
            'news' => $this->extractor->getNewsByTopic($topic),
        ]);
    }
}
