<?php


use App\Http\Controllers\API\ApiController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Login\Social;
use App\Http\Controllers\Social\Share;
use App\Http\Controllers\Trends\TrendsController;

use SaturnPHP\Intel\Http\Controllers\ArticleController;
use SaturnPHP\Intel\Http\Controllers\ChatController;
use SaturnPHP\Intel\Http\Controllers\HackerNewsController;
use SaturnPHP\Intel\Http\Controllers\NewsController;
use SaturnPHP\Intel\Http\Controllers\TopicsController;

Route::group(['middleware' => ['web']], static function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/privacy', [HomeController::class, 'index'])->name('home');
    Route::get('/terms', [HomeController::class, 'index'])->name('home');

    Route::get('news', NewsController::class . '@index')->name('news.index');
    Route::get('hacker', HackerNewsController::class . '@index')->name('hacker.index');
    Route::get('chat', ChatController::class . '@index')->name('chat.index');
    Route::post('chat', ChatController::class . '@process')->name('chat.process');
    Route::get('article/{url}', ArticleController::class . '@index')->name('article.index');
    Route::post('article/store', ArticleController::class . '@store')->name('article.store');
    Route::post('api/save-all', ArticleController::class . '@saveAll')->name('article.saveAll');
    Route::get('/topics/{topic?}', TopicsController::class . '@index')->name('topics.index');
});

