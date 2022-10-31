<?php

use App\Http\Controllers\Admin\IndexController;
use App\Http\Controllers\Admin\Student\StudentController;
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

        Route::get('/', [IndexController::class, 'index'])->name('dashboard');

        Route::prefix('/student')->group(function () {

            Route::get('/', [StudentController::class, 'index'])->name('student.index');
            Route::get('/show/{id}', [StudentController::class, 'show'])->name('student.show');
            Route::get('/create', [StudentController::class, 'create'])->name('student.create');
            Route::post('/create', [StudentController::class, 'store'])->name('student.store');
            Route::get('/edit/{id}', [StudentController::class, 'edit'])->name('student.edit');
            Route::put('/edit/{id}', [StudentController::class, 'update'])->name('student.update');
            Route::delete('/delete', [StudentController::class, 'destroy'])->name('student.delete');
            Route::get('/addgroup', [StudentController::class, 'addStudents'])->name('student.addstudent');
            Route::post('/addgroup', [StudentController::class, 'storeStudents'])->name('student.storestudent');
        });
    });
