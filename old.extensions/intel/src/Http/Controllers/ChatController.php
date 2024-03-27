<?php
declare(strict_types=1);

namespace SaturnPHP\Intel\Http\Controllers;



use SaturnPHP\Intel\Cloudflare\CloudflareService;
use SaturnPHP\Intel\Extractor\ExtractorInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Waterhole\Http\Controllers\Controller;


class ChatController extends Controller
{

    public function __construct(protected readonly CloudflareService $extractor)
    {
    }

    final public function index(Request $request): View
    {
        return view('intel::chat');
    }

    final public function process(Request $request): JsonResponse
    {
        $context = $request->input('message');

        $response = $this->extractor->rewriteText($context);

        return response()->json($response);
    }
}
