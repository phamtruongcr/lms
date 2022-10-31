<?php

use App\Http\Controllers\Admin\Course\ChapterController;
use App\Http\Controllers\Admin\Course\CourseController;
use App\Http\Controllers\Admin\Course\LessonController;
use App\Http\Controllers\Fontend\Course\CourseController as CourseCourseController;
use App\Http\Controllers\Fontend\Course\LessonController as CourseLessonController;
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
    Route::prefix('/courses')->name('course.')->group(function(){
        Route::get('/', [CourseController::class, 'index'])
        ->name('index');

        Route::get('/show/{id}', [CourseController::class, 'show'])
        ->name('detail');

        Route::get('/create', [CourseController::class, 'create'])
        ->name('create');

        Route::post('/create', [CourseController::class, 'store'])
        ->name('store');

        Route::get('/edit/{id}', [CourseController::class, 'edit'])
        ->name('edit');

        Route::post('/update/{id}', [CourseController::class, 'update'])
        ->name('update');

        Route::delete('/delete',  [CourseController::class, 'destroy'])
        ->name('destroy');
        Route::get('/search',[CourseController::class, 'search'])
        ->name('search');
    });

    Route::prefix('/chapters')->name('chapter.')->group(function(){
        Route::get('/', [ChapterController::class, 'index'])
        ->name('index');

        Route::get('/show/{id}', [ChapterController::class, 'show'])
        ->name('detail');

        Route::get('/create', [ChapterController::class, 'create'])
        ->name('create');

        Route::post('/create', [ChapterController::class, 'store'])
        ->name('store');

        Route::get('/chapter-create-of-course/{course_id}', [ChapterController::class, 'createChapterOfCourse'])
        ->name('create_chapter_of_course');

        Route::post('/chapter-create-of-course/{course_id}', [ChapterController::class, 'storeChapterOfCourse'])
        ->name('store_chapter_of_course');

        Route::get('/edit/{id}', [ChapterController::class, 'edit'])
        ->name('edit');

        Route::post('/update/{id}', [ChapterController::class, 'update'])
        ->name('update');

        Route::delete('/delete',  [ChapterController::class, 'destroy'])
        ->name('destroy');
        Route::get('/search',[ChapterController::class, 'search'])
        ->name('search');
    });

    Route::prefix('/lessons')->name('lesson.')->group(function(){
        Route::get('/', [LessonController::class, 'index'])
        ->name('index');

        Route::get('/show/{slug}', [LessonController::class, 'show'])
        ->name('detail');

        Route::get('/create', [LessonController::class, 'create'])
        ->name('create');

        Route::post('/create', [LessonController::class, 'store'])
        ->name('store');

        Route::get('/edit/{id}', [LessonController::class, 'edit'])
        ->name('edit');

        Route::post('/update/{id}', [LessonController::class, 'update'])
        ->name('update');
        
        Route::post('/add/{chapter_id}', [LessonController::class, 'addLesson'])
        ->name('add_lesson');        

        Route::delete('/delete',  [LessonController::class, 'destroy'])
        ->name('destroy');

        Route::delete('/chapter-lesson-delete',  [LessonController::class, 'destroyChapterLesson'])
        ->name('destroy_chapter_lesson');
        Route::get('/search',[LessonController::class, 'search'])
        ->name('search');
    });

    Route::prefix('/files')->name('file.')->group(function(){

        Route::delete('/delete',  [LessonController::class, 'destroyFile'])
        ->name('destroy');
    });
});

Route::prefix('/courses')->name('font_end.course.')->middleware('font.auth:user')
->group(function(){
    Route::get('/', [CourseCourseController::class, 'index'])
    ->name('index');

    Route::get('/show/{id}', [CourseCourseController::class, 'show'])
    ->name('detail');
});

Route::prefix('/lessons')->name('font_end.lesson.')->middleware('font.auth:user')
->group(function(){
    Route::get('/show/{id}/{chapter_id}', [CourseLessonController::class, 'show'])
    ->name('detail');
});