<?php

use App\Http\Controllers\AjaxController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\Auth\ResetPasswordController;
use App\Http\Controllers\Api\Auth\UserController;
use App\Http\Controllers\Api\Auth\SocialLoginController;
use App\Http\Controllers\Api\Frontend\CircleController as ApiCircleController;
use App\Http\Controllers\Api\Frontend\MapController;
use App\Http\Controllers\Api\Frontend\NotificationController as ApiNotificationController;
use App\Http\Controllers\Api\Frontend\PostController as ApiPostController;
use App\Http\Controllers\Api\Frontend\ReachController;
use App\Http\Controllers\Api\Frontend\SosController;
use App\Models\Reach;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

/* Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum'); */

Route::group(['prefix' => 'user'], function ($router) {
    //register
    Route::post('register', [RegisterController::class, 'register']);
    Route::post('/verify-email', [RegisterController::class, 'VerifyEmail']);
    Route::post('/resend-otp', [RegisterController::class, 'ResendOtp']);
    //login
    Route::post('login', [LoginController::class, 'login']);
    //forgot password
    Route::post('/send-otp', [ResetPasswordController::class, 'SendOTP']);
    Route::post('/verify-otp', [ResetPasswordController::class, 'VerifyOTP']);
    Route::post('/reset-password', [ResetPasswordController::class, 'ResetPassword']);
    //social login
    Route::post('/social-login', [SocialLoginController::class, 'SocialLogin']);
});

Route::group(['middleware' => 'auth:api', 'prefix' => 'user'], function ($router) {
    Route::post('logout', [LogoutController::class, 'logout']);
    Route::get('me', [UserController::class, 'me']);
    Route::get('/delete-account', [UserController::class, 'deleteAccount'])->name('user.delete');

    //post api start
    Route::get('/post-user/{cat?}', [ApiPostController::class, 'myPosts']);
    Route::post('/post-create', [ApiPostController::class, 'store']);
    Route::get('/post-edit/{id}', [ApiPostController::class, 'edit']);
    Route::post('/post-update', [ApiPostController::class, 'update']);
    Route::get('/post-delete/{id}', [ApiPostController::class, 'destroy']);
    //post api end

    //reach api start
    Route::get('/post-reach/{id}/{status}', [ReachController::class, 'status']);
    //reach api end

    //circle api start
    Route::post('/circle-create', [ApiCircleController::class, 'store']);
    Route::get('/circle-join/{code}', [ApiCircleController::class, 'join']);
    Route::get('/circle-all', [ApiCircleController::class, 'all']);
    //circle api end

    //Notification Route Start
    Route::get('notify', [ApiNotificationController::class, 'index']);
    Route::get('notify/read/all', [ApiNotificationController::class, 'readAll']);
    Route::get('notify/read/{id}', [ApiNotificationController::class, 'readSingle']);
    //Notification Route End

    //sos api start
    Route::get('/sos/send/{lat}/{long}', [SosController::class, 'index']);
    //sos api end

    Route::get('/emergency-contacts', [AjaxController::class, 'emergencyContact']);

});

Route::group(['prefix' => 'user'], function ($router) {
    Route::get('/post-all/{latitude?}/{longitude?}/{category?}', [MapController::class, 'index']);
    Route::get('/post-single/{id}', [ApiPostController::class, 'show']);
    Route::get('/post-category', [ApiPostController::class, 'postCategory']);

    //sos api start
    Route::get('/sos/{sos_id}', [SosController::class, 'sosApi']);
    //sos api end
});
