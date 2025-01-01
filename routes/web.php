<?php

use App\Http\Controllers\Api\Auth\SocialLoginController;
use App\Http\Controllers\ProfileController;

use App\Http\Controllers\Api\Frontend\SosController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

Route::get('/', function () {
    return redirect('login');
});

Route::get('/privacy_policy', function () {
    $file = public_path('uploads/Privacy_Policy_for_Jibon360.pdf');
    if (file_exists($file)) {
        return response()->file($file);
    }
    abort(404); 
});



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::put('/profile/avatar', [ProfileController::class, 'avatar'])->name('profile.avatar');
});

Route::get('social-login/{provider}', [SocialLoginController::class, 'RedirectToProvider'])->name('social.login');
Route::get('social-login/{provider}/callback', [SocialLoginController::class, 'HandleProviderCallback']);

//sos api start
Route::get('/sos/{sos_id}', [SosController::class, 'sosWeb']);
//sos api end


// Routes for running artisan commands
Route::get('/run-migrate-fresh', function () {
    try {
        $output = Artisan::call('migrate:fresh', ['--seed' => true]);
        return response()->json([
            'message' => 'Migrations executed.',
            'output' => nl2br($output)
        ], 200);
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'An error occurred while running migrations.',
            'error' => $e->getMessage(),
        ], 500);
    }
});
// Run composer update
Route::get('/run-composer-update', function () {
    $output = shell_exec('composer update 2>&1');
    return response()->json([
        'message' => 'Composer update command executed.',
        'output' => nl2br($output)
    ]);
});
// Run optimize:clear
Route::get('/run-optimize-clear', function () {
    $output = Artisan::call('optimize:clear');
    return response()->json([
        'message' => 'Optimize clear command executed.',
        'output' => nl2br($output)
    ]);
});
// Run db:seed
Route::get('/run-db-seed', function () {
    $output = Artisan::call('db:seed', ['--force' => true]);
    return response()->json([
        'message' => 'Database seeding executed.',
        'output' => nl2br($output)
    ]);
});
// Run cache:clear
Route::get('/run-cache-clear', function () {
    $output = Artisan::call('cache:clear');
    return response()->json([
        'message' => 'Cache cleared.',
        'output' => nl2br($output)
    ]);
});
// Run queue:restart
Route::get('/run-queue-restart', function () {
    $output = Artisan::call('queue:restart');
    return response()->json([
        'message' => 'Queue workers restarted.',
        'output' => nl2br($output)
    ]);
});



require __DIR__ . '/auth.php';
require __DIR__ . '/backend.php';
