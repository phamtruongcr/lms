<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\UsersController;

/**
 * Users Route
 */

Route::prefix('admin')
    ->group(function () {
    Route::prefix('users')->group(function () {
        //Resource Route
        Route::get('', [UsersController::class, 'index'])
            ->name('users.index')->middleware('myweb.auth:users.show');

        Route::get('/create', [UsersController::class, 'create'])
            ->name('users.create')->middleware('myweb.auth:users.create');

        Route::post('', [UsersController::class, 'store'])
            ->name('users.store')->middleware('myweb.auth:users.create');

        Route::get('/{user}', [UsersController::class, 'show'])
            ->name('users.show')->middleware('myweb.auth:users.show');

        Route::get('/{user}/edit', [UsersController::class, 'edit'])
            ->name('users.edit')->middleware('myweb.auth:users.edit');

        Route::put('/{user}', [UsersController::class, 'update'])
            ->name('users.update')->middleware('myweb.auth:users.edit');

        Route::delete('/delete', [UsersController::class, 'destroy'])
            ->name('users.destroy')->middleware('myweb.auth:users.destroy');

        // For Change User Status
        Route::put('users/status/{id}', [UsersController::class, 'status'])
            ->name('users.status')
            ->where('id', '[0-9]+')->middleware('myweb.auth:users.status');
    });
});