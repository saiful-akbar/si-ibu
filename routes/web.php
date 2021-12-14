<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

/**
 * Route middleware auth
 */
Route::middleware('auth')->group(function () {

    /**
     * Route dashboard
     */
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    /**
     * Route logout
     */
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});


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
