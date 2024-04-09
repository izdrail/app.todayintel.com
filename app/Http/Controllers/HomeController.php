<?php
declare(strict_types=1);
namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class HomeController extends Controller
{
    final function index(Request $request): Factory|View|Application
    {
        return view('home.index');
    }

    final function about(Request $request): Factory|View|Application
    {
        return view('home.about');
    }
}
