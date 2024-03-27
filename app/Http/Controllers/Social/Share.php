<?php

namespace App\Http\Controllers\Social;

use App\Data\Models\Post;
use App\Http\Controllers\Controller;
use App\Service\ShareService;
use Illuminate\View\View;

class Share extends Controller
{


    public function share(Post $post, ShareService $shareService): View
    {
        $response = $shareService->share($post);

        return view('social.post', ['post' => $post, "response" => $response]);
    }

}
