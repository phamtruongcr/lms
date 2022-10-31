<?php

use App\Http\Controllers\Admin\Group\GroupController;
use App\Http\Controllers\Admin\IndexController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::prefix('admin')->middleware('myweb.auth:manager')
    ->group(function () {
        Route::prefix('/groups')->name('group.')
        ->group(function () {
            Route::get('/', [GroupController::class, 'index'])->name('index');
            Route::get('/create', [GroupController::class, 'create'])->name('create');
            Route::post('/create', [GroupController::class, 'store'])->name('store');
            
  
        });
    });
