<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Fin360Controller;
use App\Http\Controllers\FinBotController;
use App\Http\Controllers\FinSafeController;
use App\Http\Controllers\CalculatorController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\TransferController;

/*
|--------------------------------------------------------------------------
| FINNEX Web Routes
|--------------------------------------------------------------------------
*/

// Root redirect
Route::get('/', function () {
    return session('finnex_user_id') ? redirect('/dashboard') : redirect('/login');
});

// Auth
Route::get('/login',  [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout',[AuthController::class, 'logout'])->name('logout');

// Protected routes (simple session check)
Route::middleware(\App\Http\Middleware\FinnexAuth::class)->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/fin360',    [Fin360Controller::class,    'index'])->name('fin360');
    Route::get('/finbot',    [FinBotController::class,    'index'])->name('finbot');
    Route::post('/finbot/message', [FinBotController::class, 'sendMessage'])->name('finbot.message');
    Route::get('/finsafe',   [FinSafeController::class,   'index'])->name('finsafe');
    Route::post('/finsafe/alert/{id}/dismiss', [FinSafeController::class, 'dismissAlert'])->name('finsafe.dismiss');
    Route::get('/calculator', [CalculatorController::class, 'index'])->name('calculator');
    Route::redirect('/fineasy', '/calculator')->name('fineasy');

    // Transferencias
    Route::get('/transfers',  [TransferController::class, 'index'])->name('transfers');
    Route::post('/transfers', [TransferController::class, 'send'])->name('transfers.send');

    // Profile
    Route::get('/profile',              [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile/info',        [ProfileController::class, 'updateInfo'])->name('profile.update.info');
    Route::post('/profile/password',    [ProfileController::class, 'updatePassword'])->name('profile.update.password');

    // Settings
    Route::get('/settings',             [SettingsController::class, 'index'])->name('settings');
    Route::post('/settings',            [SettingsController::class, 'update'])->name('settings.update');
    Route::get('/settings/export',      [SettingsController::class, 'exportData'])->name('settings.export');
    Route::post('/settings/reset-demo', [SettingsController::class, 'resetDemoData'])->name('settings.reset-demo');
    Route::post('/settings/delete',     [SettingsController::class, 'deleteAccount'])->name('settings.delete');
});
