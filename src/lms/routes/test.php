<?php

use App\Http\Controllers\Fontend\Quizz\TestController;
use Illuminate\Support\Facades\Route;


Route::prefix('/test')->name('font_end.test.')->middleware('myweb.auth:user')
    ->group(function () {
        Route::get('/show/{slug}', [TestController::class, 'index'])
            ->name('index');
        Route::get('/detail/{slug}', [TestController::class, 'show'])
            ->name('detail');
        Route::post('/detail/{slug}', [TestController::class, 'storeTest'])
            ->name('storeTest');
        Route::post('/getPoint', [TestController::class, 'getPoint'])
            ->name('getPoint');
    });
