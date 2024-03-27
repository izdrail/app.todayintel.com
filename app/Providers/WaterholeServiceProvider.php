<?php

namespace App\Providers;

use App\Http\Controllers\Login\Social;
use App\Http\Controllers\Social\Share;
use Illuminate\Support\Facades\Route;
use Waterhole\Extend;

class WaterholeServiceProvider extends Extend\ServiceProvider
{
    public function extend(): void
    {
        /*
        |-----------------------------------------------------------------------
        | Waterhole Extenders
        |-----------------------------------------------------------------------
        |
        | The main mechanism by which you'll hook into Waterhole is with
        | extenders. There are dozens more extenders like this covering all
        | parts of Waterhole's views and functionality, ready to hook into.
        |
        | Learn more: https://waterhole.dev/docs/extending
        |
        */

        Extend\Stylesheet::add(resource_path('css/waterhole/app.css'));

        Extend\DocumentHead::add('waterhole.head');

        Extend\Header::replace('title', 'waterhole.title');

        Extend\ForumRoutes::add(function () {

            Route::group(['middleware' => ['web','auth'],'prefix' => 'social', 'as' => 'social.'], static function () {
                //generate the index page
                //custom login
                Route::get('/login/{account}/{provider}', [Social::class, 'login'])->name('login');
                Route::get('/login/callback', [Social::class, 'callback'])->name('callback');
                //todo move share route to the social controller
                Route::get('/social/share/{post}', [Social::class, 'callback'])->name('callback');
                Route::get('/share/{post}', [Share::class, 'share'])->name('share');

            });

        });
    }
}
