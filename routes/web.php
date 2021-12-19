<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DivisiController;
use App\Http\Controllers\TransaksiController;
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
        ->middleware('menu:dashboard,read')
        ->name('dashboard');

    /**
     * Route dvisi
     */
    Route::prefix('/divisi')->group(function () {
        Route::get('/', [DivisiController::class, 'index'])
            ->middleware('menu:divisi,read')
            ->name('divisi');

        Route::get('/create', [DivisiController::class, 'create'])
            ->middleware('menu:divisi,create')
            ->name('divisi.create');

        Route::post('/', [DivisiController::class, 'store'])
            ->middleware('menu:divisi,create')
            ->name('divisi.store');

        Route::get('/{divisi}/edit', [DivisiController::class, 'edit'])
            ->middleware('menu:divisi,update')
            ->name('divisi.edit');

        Route::patch('/{divisi}', [DivisiController::class, 'update'])
            ->middleware('menu:divisi,update')
            ->name('divisi.update');

        Route::delete('/{divisi}', [DivisiController::class, 'delete'])
            ->middleware('menu:divisi,delete')
            ->name('divisi.delete');
    });

    /**
     * Route user
     */
    Route::prefix('/user')->group(function () {
        Route::get('/', [UserController::class, 'index'])
            ->middleware('menu:user,read')
            ->name('user');

        Route::get('/create', [UserController::class, 'create'])
            ->middleware('menu:user,create')
            ->name('user.create');

        Route::post('/', [UserController::class, 'store'])
            ->middleware('menu:user,create')
            ->name('user.store');

        Route::get('/{user}/edit', [UserController::class, 'edit'])
            ->middleware('menu:user,update')
            ->name('user.edit');

        Route::patch('/{user}', [UserController::class, 'update'])
            ->middleware('menu:user,update')
            ->name('user.update');

        Route::delete('/{user}', [UserController::class, 'delete'])
            ->middleware('menu:user,delete')
            ->name('user.delete');

        Route::get('/menu-akses/{user}', [UserController::class, 'detailMenuAkses'])
            ->middleware('menu:user,read')
            ->name('user.menu-akses.detail');

        Route::get('/menu-akses/{user}/edit', [UserController::class, 'editMenuAkses'])
            ->middleware('menu:user,update')
            ->name('user.menu-akses.edit');

        Route::patch('/menu-akses/{user}', [UserController::class, 'updateMenuAkses'])
            ->middleware('menu:user,update')
            ->name('user.menu-akses.update');
    });

    /**
     * Route budget
     */
    Route::prefix('/budget')->group(function () {
        Route::get('/', [BudgetController::class, 'index'])
            ->middleware('menu:budget,read')
            ->name('budget');

        Route::get('/create', [BudgetController::class, 'create'])
            ->middleware('menu:budget,create')
            ->name('budget.create');

        Route::post('/', [BudgetController::class, 'store'])
            ->middleware('menu:budget,create')
            ->name('budget.store');

        Route::get('/{budget}/edit', [BudgetController::class, 'edit'])
            ->middleware('menu:budget,update')
            ->name('budget.edit');

        Route::patch('/{budget}', [BudgetController::class, 'update'])
            ->middleware('menu:budget,update')
            ->name('budget.update');

        Route::delete('/{budget}', [BudgetController::class, 'delete'])
            ->middleware('menu:budget,delete')
            ->name('budget.delete');
    });

    /**
     * Route transaksi
     */
    Route::prefix('/transaksi')->group(function () {
        Route::get('/', [TransaksiController::class, 'index'])
            ->middleware('menu:read')
            ->name('transaksi');
    });
});


Route::redirect('/', '/dashboard');


Route::fallback(function () {
    return abort(404);
});
