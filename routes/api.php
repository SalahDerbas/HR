<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\MessageController;



Route::prefix('message')->group(function () {

    Route::get('list',         [MessageController::class, 'index'])->name('api.message.index');
    Route::get('show/{code}',  [MessageController::class, 'show'])->name('api.message.show');

});


Route::prefix('user')->group(function () {

    Route::post('login',               [AuthController::class, 'login'])->name('api.user.login');
    Route::post('register',            [AuthController::class, 'register'])->name('api.user.register');
    Route::post('check-otp' ,          [AuthController::class, 'check_otp'])->name('api.user.check_otp');
    Route::post('re-send-otp' ,        [AuthController::class, 'resend_otp'])->name('api.user.resend_otp');
    Route::post('login_by_google',     [AuthController::class, 'loginByGoogle'])->name('api.user.loginByGoogle');
    Route::post('login_by_facebook',   [AuthController::class, 'loginByFacebook'])->name('api.user.loginByFacebook');
    Route::post('forget-password',     [AuthController::class, 'forgetPassword'])->name('api.user.forgetPassword');
    Route::post('reset-new-password',  [AuthController::class, 'resetNewPassword'])->name('api.user.resetNewPassword');

});



Route::middleware('auth:api')->group(function () {

    Route::prefix('user')->group(function () {

    });

});
