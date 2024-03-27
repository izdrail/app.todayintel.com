<?php


use App\Http\Controllers\API\ApiController;
use App\Http\Controllers\Login\Social;
use App\Http\Controllers\Social\Share;
use App\Http\Controllers\Trends\TrendsController;
use Illuminate\Support\Facades\Route;
Route::group(['middleware' => ['web'], 'prefix' => 'api', 'as' => 'api.'], static function () {
    Route::get('/trending', [ApiController::class, 'trending'])->name('trending');
    Route::post('/search', [ApiController::class, 'search'])->name('search');
    Route::post('/extract', [ApiController::class, 'extract'])->name('extract');
});

