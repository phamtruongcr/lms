<?php

use App\Http\Controllers\Admin\Quizz\AnswerController;
use App\Http\Controllers\Admin\Quizz\QuestionController;
use App\Http\Controllers\Admin\Quizz\TestController;
use App\Http\Controllers\Fontend\Quizz\TestController as QuizzTestController;
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


Route::prefix('admin')->middleware('myweb.auth:lecturer')
->group(function(){
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
        ->name('destroy');
    });
    Route::prefix('/questions')->name('question.')->group(function (){
        Route::get('/',[QuestionController::class,'index'])
        ->name('index');
        Route::get('/show/{slug}', [QuestionController::class, 'show'])
        ->name('detail');
        Route::get('/create', [QuestionController::class, 'create'])
        ->name('create');
        Route::post('/create', [QuestionController::class, 'store'])
        ->name('store');
        Route::get('/edit/{id}', [QuestionController::class, 'edit'])
        ->name('edit');
        Route::post('/edit/{id}', [QuestionController::class, 'update'])
        ->name('update');
        Route::delete('/delete', [QuestionController::class, 'destroy'])
        ->name('destroy');
        Route::get('/search', [QuestionController::class, 'searchAjax'])
        ->name('searchAjax');
        Route::post('/getStatus',[TestController::class, 'getStatus'])
        ->name('getStatus');
        Route::get('/filter',[QuestionController::class, 'filterQuestions'])
        ->name('filterQuestions');
    });
    Route::prefix('/tests')->name('test.')->group(function (){
        Route::get('/',[TestController::class,'index'])
        ->name('index');
        Route::get('/show/{slug}', [TestController::class, 'show'])
        ->name('detail');
        Route::get('/create', [TestController::class, 'create'])
        ->name('create');
        Route::post('/create', [TestController::class, 'store'])
        ->name('store');
        Route::get('/edit/{id}', [TestController::class, 'edit'])
        ->name('edit');
        Route::post('/edit/{id}', [TestController::class, 'update'])
        ->name('update');
        Route::delete('/delete', [TestController::class, 'destroy'])
        ->name('destroy');
        Route::post('/get-question-by-lesson',[TestController::class, 'getQuestions'])
        ->name('getQuestions');
        Route::post('/get-total-point',[TestController::class, 'getTotalPoint'])
        ->name('getTotalPoint');
        Route::get('/search', [TestController::class, 'search'])
        ->name('search');
        Route::get('/filter', [TestController::class, 'filter'])
        ->name('filter');
    });
});

Route::get('/timer', [QuizzTestController::class, 'timer'])->name('timer');
