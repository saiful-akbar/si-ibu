<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DivisiController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/**
 * Route middleware guest
 */
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login.view');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
});



/**
 * Route middleware auth
 */
Route::middleware('auth')->group(function () {

    /**
     * Route logout
     */
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    /**
     * Route dashboard
     */
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware('akses:dashboard,read')
        ->name('dashboard');

    /**
     * Route dvisi
     */
    Route::prefix('/divisi')->group(function () {
        Route::get('/', [DivisiController::class, 'index'])
            ->middleware('akses:divisi,read')
            ->name('divisi');

        Route::get('/create', [DivisiController::class, 'create'])
            ->middleware('akses:divisi,create')
            ->name('divisi.create');

        Route::post('/', [DivisiController::class, 'store'])
            ->middleware('akses:divisi,create')
            ->name('divisi.store');

        Route::get('/{divisi}/edit', [DivisiController::class, 'edit'])
            ->middleware('akses:divisi,update')
            ->name('divisi.edit');

        Route::patch('/{divisi}', [DivisiController::class, 'update'])
            ->middleware('akses:divisi,update')
            ->name('divisi.update');

        Route::delete('/{divisi}', [DivisiController::class, 'delete'])
            ->middleware('akses:divisi,delete')
            ->name('divisi.delete');
    });

    /**
     * Route user
     */
    Route::prefix('/user')->group(function () {
        Route::get('/', [UserController::class, 'index'])
            ->middleware('akses:user,read')
            ->name('user');

        Route::get('/create', [UserController::class, 'create'])
            ->middleware('akses:user,create')
            ->name('user.create');

        Route::post('/', [UserController::class, 'store'])
            ->middleware('akses:user,create')
            ->name('user.store');

        Route::get('/{user}/edit', [UserController::class, 'edit'])
            ->middleware('akses:user,update')
            ->name('user.edit');

        Route::patch('/{user}', [UserController::class, 'update'])
            ->middleware('akses:user,update')
            ->name('user.update');

        Route::delete('/{user}', [UserController::class, 'delete'])
            ->middleware('akses:user,delete')
            ->name('user.delete');

        Route::get('/menu-akses/{user}', [UserController::class, 'detailMenuAkses'])
            ->middleware('akses:user,read')
            ->name('user.menu-akses.detail');

        Route::get('/menu-akses/{user}/edit', [UserController::class, 'editMenuAkses'])
            ->middleware('akses:user,update')
            ->name('user.menu-akses.edit');

        Route::patch('/menu-akses/{user}', [UserController::class, 'updateMenuAkses'])
            ->middleware('akses:user,update')
            ->name('user.menu-akses.update');
    });
});


Route::redirect('/', '/dashboard');


Route::fallback(function () {
    return abort(404);
});
