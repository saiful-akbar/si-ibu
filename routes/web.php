<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DivisiController;
use Illuminate\Support\Facades\Route;

/**
 * Route middleware guest
 */
Route::middleware('guest')->group(function () {

    /**
     * Route login
     */
    Route::prefix('/login')->group(function () {
        Route::get('/', [AuthController::class, 'index'])->name('login.view');
        Route::post('/', [AuthController::class, 'login'])->name('login');
    });
});

/**
 * Route middleware auth
 */
Route::middleware('auth')->group(function () {
    
    // Route logout
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    // Route dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Route dvisi
    Route::prefix('/divisi')->group(function () {
        Route::get('/', [DivisiController::class, 'index'])->name('divisi');
    });
});
