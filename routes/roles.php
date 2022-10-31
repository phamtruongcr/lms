<?php

use App\Http\Controllers\Admin\Quizz\AnswerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RolesController;

/**
 * Users Role Route
 */

Route::prefix('admin')->middleware('myweb.auth:manager')
    ->group(function () {

    Route::prefix('/roles')->group(function () {
        //Resource Route
        Route::get('', [RolesController::class, 'index'])
            ->name('roles.index');

        Route::get('/create', [RolesController::class, 'create'])
            ->name('roles.create');

        Route::post('', [RolesController::class, 'store'])
            ->name('roles.store');

        Route::get('/{role}', [RolesController::class, 'show'])
            ->name('roles.show');

        Route::get('/{role}/edit', [RolesController::class, 'edit'])
            ->name('roles.edit');

        Route::put('/{role}', [RolesController::class, 'update'])
            ->name('roles.update');

        Route::get('/{role}/duplicate', [RolesController::class, 'duplicate'])
            ->name('roles.duplicate');

        Route::delete('/delete', [RolesController::class, 'destroy'])
            ->name('roles.destroy');
    });
    Route::prefix('/answers')->name('answer.')->group(function (){
        Route::get('/',[AnswerController::class,'index'])
        ->name('index');
        Route::get('/show/{slug}', [AnswerController::class, 'show'])
        ->name('detail');
        Route::get('/create', [AnswerController::class, 'create'])
        ->name('create');
        Route::post('/create', [AnswerController::class, 'store'])
        ->name('store');
        Route::get('/edit/{id}', [AnswerController::class, 'edit'])
        ->name('edit');
        Route::post('/edit/{id}', [AnswerController::class, 'update'])
        ->name('update');
        Route::delete('/delete', [AnswerController::class, 'destroy'])
        ->name('delete');
    });
});