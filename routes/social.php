<?php


use App\Http\Controllers\API\ApiController;
use App\Http\Controllers\Login\Social;
use App\Http\Controllers\Social\Share;
use App\Http\Controllers\Trends\TrendsController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['web'],'prefix' => 'social', 'as' => 'social.'], static function () {
    //generate the index page
    //custom login
    Route::get('/login/{account}/{provider}', [Social::class, 'login'])->name('login');
    Route::get('/login/callback', [Social::class, 'callback'])->name('callback');

    Route::get('/social/share/{post}', [Social::class, 'callback'])->name('callback');
    Route::get('/share/{post}', [Share::class, 'share'])->name('share');

});

