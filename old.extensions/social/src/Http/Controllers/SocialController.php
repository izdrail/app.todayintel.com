<?php
declare(strict_types=1);

namespace Cornatul\Social\Http\Controllers;

use Illuminate\View\View;
use Waterhole\Http\Controllers\Controller;

class SocialController extends Controller
{

    public function __construct()
    {
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    final public function index(): \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
    {
        return view('social::index', [

        ]);
    }


    final public function store(): View
    {
        return view('social::index', [

        ]);
    }
}
