<?php

use App\Http\Controllers\Admin\IndexController;
use App\Http\Controllers\Fontend\IndexController as FontendIndexController;
use Illuminate\Support\Facades\Route;

require 'auth.php';
require 'student.php';
require 'addGroup.php';
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

Route::get('/', [FontendIndexController::class, 'index'])->name('home');
Route::get('/404', function () {
    return view('font_end/404');
})->name(404);


Route::prefix('admin')->middleware('myweb.auth:manager')
->group(function(){
    Route::get('/dashboard', [IndexController::class, 'index'])
    ->name('dashboard');

});

require 'auth.php';
require 'course.php';
require 'quizz.php';
require 'test.php';
require 'addGroup.php';




