<?php

use App\Http\Controllers\Auth\ForgotController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
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

/**
 * Login Route
 */
Route::group(['prefix' => 'admin/login', 'namespace' => 'Auth'], function () {

    Route::get('', [LoginController::class, 'login'])
            ->name('login.admin');

    // For Action
    Route::post('', [LoginController::class, 'postLogin'])
            ->name('login.admin.post');
});

Route::group(['prefix' => '/login', 'namespace' => 'Auth'], function () {

        Route::get('', [LoginController::class, 'font_login'])
                ->name('login');
    
        // For Action
        Route::post('', [LoginController::class, 'font_postLogin'])
                ->name('login.post');
    });

/**
 * Logout Route
 */
Route::group(['prefix' => '/admin/logout', 'namespace' => 'Auth'], function () {

        Route::get('',[LogoutController::class, 'logout'])
                ->name('logout.admin');
});

Route::group(['prefix' => '/logout', 'namespace' => 'Auth'], function () {

        Route::get('',[LogoutController::class, 'font_logout'])
                ->name('logout');
});

/**
 * Users Register Route
 */
Route::group(['prefix' => '/register', 'namespace' => 'Auth'], function () {

Route::get('', [RegisterController::class, 'register'])
        ->name('register');

// For Action
Route::post('', [RegisterController::class, 'postRegister'])
        ->name('register.post');

Route::get('activate/{userId}/{code}', [RegisterController::class, 'activate'])
        ->name('register.activate');
});

/**
 * Reset Password Email Route
 */
Route::group(['prefix' => '/forgot-password', 'namespace' => 'Auth'], function () {

Route::get('', [ForgotController::class, 'forgotPassword'])
        ->name('forgotPassword');

// For Action
Route::post('', [ForgotController::class, 'processForgotPassword'])
        ->name('forgotPassword.post');

});


/**
 * Reset Password Route
 */
Route::group(['prefix' => '/reset-password', 'namespace' => 'Auth'], function () {

Route::get('{userId}/{code}', [ForgotController::class, 'resetPassword'])
        ->name('resetPassword');

// For Action
Route::post('{userId}/{code}', [ForgotController::class, 'processResetPassword'])
        ->name('resetPassword.post');
// Route::post('{userId}/{code}', ['uses' => 'ForgotController@processResetPassword'])->name('resetPassword.post');

});

/**
 * Change Password Route
 */
Route::group(['prefix' => '/change-password', 'namespace' => 'Auth'], function () {

Route::get('', [ForgotController::class, 'changePassword'])
        ->name('changePassword');

// For Action
Route::post('', [ForgotController::class, 'processChangePassword'])
        ->name('changePassword.post');

});

require 'roles.php';
require 'users.php';

