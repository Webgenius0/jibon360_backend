<?php
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\Web\Backend\DashboardController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Web\Backend\EmergencyContactController;
use App\Http\Controllers\Web\Backend\MailController;
use App\Http\Controllers\Web\Backend\ModeratorController;
use App\Http\Controllers\Web\Backend\NotificationController as WebNotificationController;
use App\Http\Controllers\Web\Backend\PostCategoryController;
use App\Http\Controllers\Web\Backend\PostController as BackendPostController;
use App\Http\Controllers\Web\Backend\SettingController;
use App\Http\Controllers\Web\Backend\SmsController;
use App\Http\Controllers\Web\Backend\SocialController;
use App\Http\Controllers\Web\Backend\UserController as BackendUserController;
use Illuminate\Support\Facades\Route;




Route::controller(DashboardController::class)->prefix('dashboard')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', 'index')->name('dashboard');

    //all user route start
    Route::get('users', [BackendUserController::class, 'index'])->name('users');
    Route::get('users/status/{id}', [BackendUserController::class, 'status'])->name('user.status');
    Route::post('users/warraning/{id}', [BackendUserController::class, 'warraning'])->name('user.warraning');
    //ajax
    Route::get('users/ajax', [BackendUserController::class, 'getUserByAjax'])->name('users.ajax');
    //all user route end

    //post route start
    Route::controller(BackendPostController::class)->group(function () {
        Route::get('post-all/{status?}', 'index')->name('post.all');
        Route::get('post-history', 'history')->name('post.history');
        Route::get('post/{id}/{notify?}', 'show')->name('post.show');
        Route::get('post-status/{status?}', 'status')->name('post.status');
        Route::get('post-report', 'report')->name('post.report');
    });
    //post route end

    //Notification Route Start
    Route::get('notification', [WebNotificationController::class, 'index'])->name('notification.index');
    Route::get('notification/read/all', [WebNotificationController::class, 'readAll'])->name('notification.read.all');
    Route::get('notification/read/{id}', [WebNotificationController::class, 'readSingle'])->name('notification.read.single');
    //Notification Route End

    //admin information fatch by the ajax
    Route::get('info', [AjaxController::class, 'info'])->name('info');
});

Route::prefix('dashboard')->middleware(['auth', 'verified', 'admin'])->group(function () {

    //moderator route start
    Route::get('moderator/index', [ModeratorController::class, 'index'])->name('moderator.index');
    Route::get('moderator/create', [ModeratorController::class, 'create'])->name('moderator.create');
    Route::post('moderator/store', [ModeratorController::class, 'store'])->name('moderator.store');
    Route::get('moderator/edit/{id}', [ModeratorController::class, 'edit'])->name('moderator.edit');
    Route::post('moderator/update/{id}', [ModeratorController::class, 'update'])->name('moderator.update');
    Route::get('moderator/delete/{id}', [ModeratorController::class, 'destroy'])->name('moderator.delete');
    Route::get('moderator/permission', [ModeratorController::class, 'permission'])->name('moderator.permission');
    //moderator route end

    // Post Category Route Start
    Route::controller(PostCategoryController::class)->group(function () {
        Route::get('post-category', 'index')->name('post-category.index');
        Route::get('post-category/create', 'create')->name('post-category.create');
        Route::post('post-category', 'store')->name('post-category.store');
        Route::get('post-category/edit/{id}', 'edit')->name('post-category.edit');
        Route::post('post-category/update', 'update')->name('post-category.update');
        Route::delete('post-category/{id}', 'destroy')->name('post-category.destroy');
        Route::get('post-category/status/{id}', 'status')->name('post-category.status');
    });
    // Post Category Route End

    // Emergency Contacts Route Start
    Route::controller(EmergencyContactController::class)->group(function () {
        Route::get('emergency-contacts', 'index')->name('emergency-contacts.index');
        Route::get('/emergency-contacts/create', 'create')->name('emergency-contacts.create');
        Route::post('emergency-contacts', 'store')->name('emergency-contacts.store');
        Route::get('/emergency-contacts/edit/{id}', 'edit')->name('emergency-contacts.edit');
        Route::post('emergency-contacts/update', 'update')->name('emergency-contacts.update');
        Route::delete('emergency-contacts/{id}', 'destroy')->name('emergency-contacts.destroy');
        Route::get('emergency-contacts/status/{id}', 'status')->name('emergency-contacts.status');
    });
    // Emergency Contacts Route End

    //Settings
    Route::get('settings/general', [SettingController::class, 'index'])->name('settings.general');
    Route::put('settings/general', [SettingController::class, 'update'])->name('settings.general.update');

    //sms
    Route::get('settings/sms', [SmsController::class, 'index'])->name('settings.sms');
    Route::put('settings/sms', [SmsController::class, 'update'])->name('settings.sms.update');

    //social
    Route::get('settings/social', [SocialController::class, 'index'])->name('settings.social');
    Route::put('settings/facebook', [SocialController::class, 'facebook'])->name('settings.facebook.update');
    Route::put('settings/google', [SocialController::class, 'google'])->name('settings.google.update');

    //mail
    Route::get('settings/mail', [MailController::class, 'index'])->name('settings.mail');
    Route::put('settings/mail', [MailController::class, 'update'])->name('settings.mail.update');

});