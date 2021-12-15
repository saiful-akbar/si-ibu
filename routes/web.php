<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DivisiController;
use Illuminate\Support\Facades\Route;

/**
 * Route middleware guest
 */
Route::middleware('guest')->group(function () {

    // Route login
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
});



/**
 * Middleware auth & admin
 */
Route::middleware(['auth', 'role:admin'])->group(function () {

    // Route dvisi
    Route::prefix('/divisi')->group(function () {
        Route::get('/', [DivisiController::class, 'index'])->name('divisi');
        Route::get('/create', [DivisiController::class, 'create'])->name('divisi.create');
        Route::post('/', [DivisiController::class, 'store'])->name('divisi.store');
        Route::get('/{divisi}/edit', [DivisiController::class, 'edit'])->name('divisi.edit');
        Route::patch('/{divisi}', [DivisiController::class, 'update'])->name('divisi.update');
        Route::delete('/{divisi}', [DivisiController::class, 'delete'])->name('divisi.delete');
    });
});
