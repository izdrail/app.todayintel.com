<?php


use App\Http\Controllers\API\ApiController;
use App\Http\Controllers\Login\Social;
use App\Http\Controllers\Social\Share;
use App\Http\Controllers\Trends\TrendsController;
use Illuminate\Support\Facades\Route;
Route::group(['middleware' => ['web'], 'as' => 'trending.'], static function () {
    Route::get('/trending', [TrendsController::class, 'index'])->name('index');
});

