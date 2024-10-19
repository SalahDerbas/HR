<?php

use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Website\WebsiteController;
use App\Http\Controllers\Auth\AuthinticateController;
use App\Http\Controllers\Dashboard\HomeController;
use App\Http\Controllers\Dashboard\SettingsController;
use App\Http\Controllers\Dashboard\ReportsController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\PushNotificationController;
use App\Http\Controllers\Dashboard\RoleController;


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


Route::group(['middleware' => ['guest']], function () {
    Route::get('/',                 [WebsiteController::class ,'index'])->name('website.index');
    Route::get('/contact-us',       [WebsiteController::class ,'contact_us'])->name('website.contact_us');
    Route::get('/forget_password' , [AuthinticateController::class , 'forget'])->name('forget_password');
});

Auth::routes();

 //==============================Translate all pages============================
Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'auth']
    ], function () {



     //============================== Dashboard ============================
    Route::get('/dashboard', [HomeController::class , 'index'])->name('dashboard');
    Route::get('/users/profile' , [UserController::class , 'getProfile' ])->name('Dashboard.Users.getProfile');
    Route::post('/users/profile' , [UserController::class , 'updateProfile' ])->name('Dashboard.Users.updateProfile');
    Route::get('/users/resetPassword' , [UserController::class , 'resetPassword' ])->name('Dashboard.Users.resetPassword');
    Route::post('/users/updatePassword' , [UserController::class , 'updatePassword' ])->name('Dashboard.Users.updatePassword');

    Route::get('/users' , [UserController::class , 'index'])->name('Dashboard.Users.index');
    // for change status for user
   Route::get('activate/{id}','Dashboard\UserController@activate')->name('Dashboard.Users.activate');

   Route::post('/users/store' , [UserController::class , 'store'])->name('Dashboard.Users.store');
   Route::put('/users/update' , [UserController::class , 'update'])->name('Dashboard.Users.update');
   Route::delete('/users/delete' , [UserController::class , 'destroy'])->name('Dashboard.Users.destroy');

   Route::get('/Reports', [ReportsController::class , 'index'])->name('Dashboard.Reports.index');
    Route::get('/settings', [SettingsController::class , 'index'] )->name('Dashboard.Settings.index');
    Route::get('/PushNotification', [PushNotificationController::class , 'index'])->name('Dashboard.PushNotification.index');
    Route::post('/PushNotification/store', [PushNotificationController::class , 'store'])->name('Dashboard.PushNotification.store');


    // for read 1 notification for user
    Route::get('readNotification/{id}', [ PushNotificationController::class , 'readNotification']);
    // for read all notifications for user
    Route::get('markallasread',function(){
         Auth::user()->unreadNotifications->markAsRead(); return redirect()->back();
    })->name('markallasread');


    Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index'])->name('logs');

    Route::resource('Roles' , 'Dashboard\RoleController');
    // for get Permissions Page in dashboard
    Route::get('/permissions' ,[RoleController::class , 'permissions'] )->name('permissions');



});
