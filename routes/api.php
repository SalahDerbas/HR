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



// Auth API's
use App\Http\Controllers\API\Auth\AuthController;

// Message API's
use App\Http\Controllers\API\Message\MessageController;

// Lookup API's
use App\Http\Controllers\API\Lookup\LookupController;

// User API's
use App\Http\Controllers\API\User\{
    ContentController,
    NotificationController,
    VacationController,
    MissingPunchsController,
    LeaveController,
    ExperienceController,
    EventController,
    DocumentController,
    CertificateController,
    AttendanceController,
    AssetController,
    DashboardController
};

// Company API's
use App\Http\Controllers\API\Company\{
    DepartmentController,
    SettingController
};

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Public User Routes
Route::prefix('user')->group( function () {

    Route::post('login',               [AuthController::class, 'login'])->name('api.user.login');
    Route::post('check-otp' ,          [AuthController::class, 'checkOtp'])->name('api.user.check_otp');
    Route::post('re-send-otp' ,        [AuthController::class, 'resendOtp'])->name('api.user.resend_otp');
    Route::post('login-by-google',     [AuthController::class, 'loginByGoogle'])->name('api.user.login_by_google');
    Route::post('login-by-facebook',   [AuthController::class, 'loginByFacebook'])->name('api.user.login_by_facebook');
    Route::post('login-by-apple',      [AuthController::class, 'loginByApple'])->name('api.user.login_by_apple');
    Route::post('forget-password',     [AuthController::class, 'forgetPassword'])->name('api.user.forget_password');
    Route::post('reset-password',      [AuthController::class, 'resetPassword'])->name('api.user.reset_password');

    // Content Routes API For HR Project
    Route::prefix('content')->group( function () {

        Route::get('terms-conditions',     [ContentController::class, 'getTermsConditions'])->name('api.content.get_terms_conditions');
        Route::get('privacy-policy',       [ContentController::class, 'getPrivacyPolicy'])->name('api.content.get_privacy_policy');
        Route::get('about-us',             [ContentController::class, 'getAboutUs'])->name('api.content.get_about_us');
        Route::get('faq',                  [ContentController::class, 'getFAQ'])->name('api.content.get_faq');
        Route::get('sliders',              [ContentController::class, 'getSliders'])->name('api.content.get_sliders');
        Route::post('contact-us',          [ContentController::class, 'contactUs'])->name('api.content.contact_us');
    });

});





// Authenticated User Routes
Route::group(['middleware' => ['auth:api']],function () {

    // User Routes API With Authenticate
    Route::prefix('user')->group( function () {

        Route::get('',                        [AuthController::class, 'index'])->name('api.user.index');
        Route::get('get-profile',             [AuthController::class, 'getProfile'])->name('api.user.get_profile');
        Route::get('refresh-token',           [AuthController::class, 'refreshToken'])->name('api.user.refresh_token');
        Route::get('logout' ,                 [AuthController::class, 'logout'])->name('api.user.logout');
        Route::post('store',                  [AuthController::class, 'store'])->name('api.user.store');
        Route::post('update-profile',         [AuthController::class, 'updateProfile'])->name('api.user.update_profile');
        Route::delete('delete',               [AuthController::class, 'delete'])->name('api.user.delete');


        // Notification Routes API For HR Project
        Route::prefix('notification')->group( function () {

            Route::get('list',                [NotificationController::class, 'index'])->name('api.user.notification.index');
            Route::get('update-enable',       [NotificationController::class, 'updateEnable'])->name('api.user.notification.update_enable');

        });

        // Common resource routes for HR-related entities
        $entities = [
                // 'vacation'            => \App\Http\Controllers\API\User\VacationController::class,
                // 'missing-punches'     => MissingPunchsController::class,
                // 'leave'               => LeaveController::class,
                'experience'          => ExperienceController::class,
                'event'               => EventController::class,
                'document'            => DocumentController::class,
                'certificate'         => CertificateController::class,
                'attendance'          => AttendanceController::class,
                'asset'               => AssetController::class,
        ];
        Route::prefix('vacation')->group( function () {

            Route::get('' ,         [VacationController::class , 'index'])->name("api.user.vacation.index");
            Route::get('{id}' ,     [VacationController::class , 'show'])->name("api.user.vacation.show");
            Route::post('' ,        [VacationController::class , 'store'])->name("api.user.vacation.store");
            Route::post('{id}' ,    [VacationController::class , 'update'])->name("api.user.vacation.update");
            Route::delete('{id}' ,  [VacationController::class , 'destroy'])->name("api.user.vacation.destroy");
        });

        Route::prefix('missing-punches')->group( function () {

            Route::get('' ,         [MissingPunchsController::class , 'index'])->name("api.user.missing_punches.index");
            Route::get('{id}' ,     [MissingPunchsController::class , 'show'])->name("api.user.missing_punches.show");
            Route::post('' ,        [MissingPunchsController::class , 'store'])->name("api.user.missing_punches.store");
            Route::post('{id}' ,    [MissingPunchsController::class , 'update'])->name("api.user.missing_punches.update");
            Route::delete('{id}' ,  [MissingPunchsController::class , 'destroy'])->name("api.user.missing_punches.destroy");
        });

        Route::prefix('leave')->group( function () {

            Route::get('' ,         [LeaveController::class , 'index'])->name("api.user.leave.index");
            Route::get('{id}' ,     [LeaveController::class , 'show'])->name("api.user.leave.show");
            Route::post('' ,        [LeaveController::class , 'store'])->name("api.user.leave.store");
            Route::post('{id}' ,    [LeaveController::class , 'update'])->name("api.user.leave.update");
            Route::delete('{id}' ,  [LeaveController::class , 'destroy'])->name("api.user.leave.destroy");
        });

        foreach ($entities as $entity => $controller) {
            Route::get($entity , [$controller , 'index'])->name("api.user.$entity.index");

            Route::resource($entity, $controller,
            ['names' => [
                            'index'   => "api.user.$entity.index",
                            'show'    => "api.user.$entity.show",
                            'store'   => "api.user.$entity.store",
                            'update'  => "api.user.$entity.update",
                            'destroy' => "api.user.$entity.destroy",
                        ]
           ])->except(['create', 'edit']);
        }

        // Dashboard Routes API For HR Project
        Route::get('dashboard',                [DashboardController::class, 'index'])->name('api.user.dashboard.index');

    });





    // Company API For HR Project
    Route::prefix('company')->group( function () {

        // Notification API For HR Project
        Route::prefix('notification')->group( function () {

            Route::post('send',               [NotificationController::class, 'send'])->name('api.company.notification.send');
        });

        // Department API For HR Project
        Route::prefix('department')->group( function () {
            Route::resource('/', DepartmentController::class)->except(['create', 'edit']);
        });

        // Setting API For HR Project
        Route::get('setting',                [SettingController::class, 'setting'])->name('api.company.setting');


    });



});




















// Lookups API For HR Project
Route::prefix('lookups')->group( function () {

    Route::get('countries',             [LookupController::class, 'countries'])->name('api.lookups.countries');
    Route::get('genders',               [LookupController::class, 'genders'])->name('api.lookups.genders');
    Route::get('regions',               [LookupController::class, 'regions'])->name('api.lookups.regions');
    Route::get('material_status',       [LookupController::class, 'materialStatus'])->name('api.lookups.material_status');
    Route::get('work_types',            [LookupController::class, 'workTypes'])->name('api.lookups.work_types');
    Route::get('contract_types',        [LookupController::class, 'contractTypes'])->name('api.lookups.contract_types');
    Route::get('status_user',           [LookupController::class, 'statusUser'])->name('api.lookups.status_user');
    Route::get('status_attendance',      [LookupController::class, 'statusAttendance'])->name('api.lookups.status_attendance');
    Route::get('reason_leave',          [LookupController::class, 'reasonLeave'])->name('api.lookups.reason_leave');
    Route::get('status_leave',          [LookupController::class, 'statusLeave'])->name('api.lookups.status_leave');
    Route::get('vacation_type',         [LookupController::class, 'vacationTypes'])->name('api.lookups.vacation_type');
    Route::get('asset_type',            [LookupController::class, 'assetTypes'])->name('api.lookups.asset_type');
    Route::get('missing_punch_type',    [LookupController::class, 'missingPunchTypes'])->name('api.lookups.missing_punch_type');
    Route::get('document_type',         [LookupController::class, 'documentTypes'])->name('api.lookups.document_type');

});



Route::prefix('message')->group(function () {
    Route::get('list',         [MessageController::class, 'index'])->name('api.message.index');
    Route::get('show/{code}',  [MessageController::class, 'show'])->name('api.message.show');
});
