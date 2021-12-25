<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DivisiController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\JenisBelanjaController;
use App\Http\Controllers\LaporanTransaksiController;
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
    Route::prefix('/dashboard')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])
            ->middleware('menu:/dashboard,read')
            ->name('dashboard');

        Route::get('/{year}', [DashboardController::class, 'globalChart'])
            ->middleware('menu:/dashboard,read')
            ->name('dashboard.global');

        Route::get('/{divisi}/{year}', [DashboardController::class, 'divisiChart'])
            ->middleware('menu:/dashboard,read')
            ->name('dashboard.divisi');
    });

    /**
     * Route dvisi
     */
    Route::prefix('/divisi')->group(function () {
        Route::get('/', [DivisiController::class, 'index'])
            ->middleware('menu:/divisi,read')
            ->name('divisi');

        Route::get('/create', [DivisiController::class, 'create'])
            ->middleware('menu:/divisi,create')
            ->name('divisi.create');

        Route::post('/', [DivisiController::class, 'store'])
            ->middleware('menu:/divisi,create')
            ->name('divisi.store');

        Route::get('/{divisi}/edit', [DivisiController::class, 'edit'])
            ->middleware('menu:/divisi,update')
            ->name('divisi.edit');

        Route::patch('/{divisi}', [DivisiController::class, 'update'])
            ->middleware('menu:/divisi,update')
            ->name('divisi.update');

        Route::delete('/{divisi}', [DivisiController::class, 'delete'])
            ->middleware('menu:/divisi,delete')
            ->name('divisi.delete');
    });

    /**
     * Route user
     */
    Route::prefix('/user')->group(function () {
        Route::get('/', [UserController::class, 'index'])
            ->middleware('menu:/user,read')
            ->name('user');

        Route::get('/create', [UserController::class, 'create'])
            ->middleware('menu:/user,create')
            ->name('user.create');

        Route::post('/', [UserController::class, 'store'])
            ->middleware('menu:/user,create')
            ->name('user.store');

        Route::get('/{user}/edit', [UserController::class, 'edit'])
            ->middleware('menu:/user,update')
            ->name('user.edit');

        Route::patch('/{user}', [UserController::class, 'update'])
            ->middleware('menu:/user,update')
            ->name('user.update');

        Route::delete('/{user}', [UserController::class, 'delete'])
            ->middleware('menu:/user,delete')
            ->name('user.delete');

        Route::get('/menu-akses/{user}', [UserController::class, 'detailMenuAkses'])
            ->middleware('menu:/user,read')
            ->name('user.menu-akses.detail');

        Route::get('/menu-akses/{user}/edit', [UserController::class, 'editMenuAkses'])
            ->middleware('menu:/user,update')
            ->name('user.menu-akses.edit');

        Route::patch('/menu-akses/{user}', [UserController::class, 'updateMenuAkses'])
            ->middleware('menu:/user,update')
            ->name('user.menu-akses.update');
    });

    /**
     * Route budget
     */
    Route::prefix('/budget')->group(function () {
        Route::get('/', [BudgetController::class, 'index'])
            ->middleware('menu:/budget,read')
            ->name('budget');

        Route::get('/create', [BudgetController::class, 'create'])
            ->middleware('menu:/budget,create')
            ->name('budget.create');

        Route::post('/', [BudgetController::class, 'store'])
            ->middleware('menu:/budget,create')
            ->name('budget.store');

        Route::get('/{budget}', [BudgetController::class, 'show'])
            ->middleware('menu:/budget,read')
            ->name('budget.show');

        Route::get('/{budget}/edit', [BudgetController::class, 'edit'])
            ->middleware('menu:/budget,update')
            ->name('budget.edit');

        Route::patch('/{budget}', [BudgetController::class, 'update'])
            ->middleware('menu:/budget,update')
            ->name('budget.update');

        Route::delete('/{budget}', [BudgetController::class, 'delete'])
            ->middleware('menu:/budget,delete')
            ->name('budget.delete');
    });

    /**
     * Route jenis belanja
     */
    Route::prefix('/jenis-belanja')->group(function () {
        Route::get('/', [JenisBelanjaController::class, 'index'])
            ->middleware('menu:/jenis-belanja,read')
            ->name('jenis-belanja');

        Route::get('/create', [JenisBelanjaController::class, 'create'])
            ->middleware('menu:/jenis-belanja,create')
            ->name('jenis-belanja.create');

        Route::post('/', [JenisBelanjaController::class, 'store'])
            ->middleware('menu:/jenis-belanja,create')
            ->name('jenis-belanja.store');

        Route::get('/{jenisBelanja}/edit', [JenisBelanjaController::class, 'edit'])
            ->middleware('menu:/jenis-belanja,update')
            ->name('jenis-belanja.edit');

        Route::patch('/{jenisBelanja}', [JenisBelanjaController::class, 'update'])
            ->middleware('menu:/jenis-belanja,update')
            ->name('jenis-belanja.update');

        Route::delete('/{jenisBelanja}', [JenisBelanjaController::class, 'delete'])
            ->middleware('menu:/jenis-belanja,delete')
            ->name('jenis-belanja.delete');
    });

    /**
     * Route transaksi
     */
    Route::prefix('/transaksi')->group(function () {
        Route::get('/', [TransaksiController::class, 'index'])
            ->middleware('menu:/transaksi,read')
            ->name('transaksi');

        Route::get('/create', [TransaksiController::class, 'create'])
            ->middleware('menu:/transaksi,create')
            ->name('transaksi.create');

        Route::post('/', [TransaksiController::class, 'store'])
            ->middleware('menu:/transaksi,create')
            ->name('transaksi.store');

        Route::get('/{transaksi}', [TransaksiController::class, 'show'])
            ->middleware('menu:/transaksi,read')
            ->name('transaksi.show');

        Route::get('/{transaksi}/edit', [TransaksiController::class, 'edit'])
            ->middleware('menu:/transaksi,update')
            ->name('transaksi.edit');

        Route::patch('/{transaksi}', [TransaksiController::class, 'update'])
            ->middleware('menu:/transaksi,update')
            ->name('transaksi.update');

        Route::delete('/{transaksi}', [TransaksiController::class, 'delete'])
            ->middleware('menu:/transaksi,delete')
            ->name('transaksi.delete');

        Route::get('/{transaksi}/download', [TransaksiController::class, 'download'])
            ->middleware('menu:/transaksi,read')
            ->name('transaksi.download');
    });

    /**
     * Route laporan transaksi
     */
    Route::prefix('/laporan-transaksi')->group(function () {
        Route::get('/', [LaporanTransaksiController::class, 'index'])
            ->middleware('menu:/laporan-transaksi,read')
            ->name('laporan-transaksi');
    });
});


Route::redirect('/', '/dashboard');


Route::fallback(function () {
    return abort(404);
});
