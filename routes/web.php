<?php

use App\Exports\UsersExport;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DivisiController;
use App\Http\Controllers\JenisBelanjaController;
use App\Http\Controllers\LaporanTransaksiController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;

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

        Route::get('/divisi/{divisi}/{year}', [DashboardController::class, 'divisiChart'])
            ->middleware('menu:/dashboard,read')
            ->name('dashboard.divisi');

        Route::get('/jenis-belanja/{divisi}/{year}', [DashboardController::class, 'jenisBelanjaChart'])
            ->middleware('menu:/dashboard,read')
            ->name('dashboard.jenisBelanja');
    });

    /**
     * Route dvisi
     */
    Route::prefix('/bagian')->group(function () {
        Route::get('/', [DivisiController::class, 'index'])
            ->middleware('menu:/bagian,read')
            ->name('bagian');

        Route::get('/create', [DivisiController::class, 'create'])
            ->middleware('menu:/bagian,create')
            ->name('bagian.create');

        Route::post('/', [DivisiController::class, 'store'])
            ->middleware('menu:/bagian,create')
            ->name('bagian.store');

        Route::get('/{divisi}/edit', [DivisiController::class, 'edit'])
            ->middleware('menu:/bagian,update')
            ->name('bagian.edit');

        Route::patch('/{divisi}', [DivisiController::class, 'update'])
            ->middleware('menu:/bagian,update')
            ->name('bagian.update');

        Route::delete('/{divisi}', [DivisiController::class, 'delete'])
            ->middleware('menu:/bagian,delete')
            ->name('bagian.delete');
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
    Route::prefix('/belanja')->group(function () {
        Route::get('/', [TransaksiController::class, 'index'])
            ->middleware('menu:/belanja,read')
            ->name('belanja');

        Route::get('/create', [TransaksiController::class, 'create'])
            ->middleware('menu:/belanja,create')
            ->name('belanja.create');

        Route::post('/', [TransaksiController::class, 'store'])
            ->middleware('menu:/belanja,create')
            ->name('belanja.store');

        Route::get('/{transaksi}', [TransaksiController::class, 'show'])
            ->middleware('menu:/belanja,read')
            ->name('belanja.show');

        Route::get('/{transaksi}/edit', [TransaksiController::class, 'edit'])
            ->middleware('menu:/belanja,update')
            ->name('belanja.edit');

        Route::patch('/{transaksi}', [TransaksiController::class, 'update'])
            ->middleware('menu:/belanja,update')
            ->name('belanja.update');

        Route::delete('/{transaksi}', [TransaksiController::class, 'delete'])
            ->middleware('menu:/belanja,delete')
            ->name('belanja.delete');

        Route::get('/{transaksi}/download', [TransaksiController::class, 'download'])
            ->middleware('menu:/belanja,read')
            ->name('belanja.download');

        Route::get('/export/excel', [TransaksiController::class, 'exportExcel'])
            ->middleware('menu:/belanja,read')
            ->name('belanja.excel');

        Route::get('/export/pdf', [TransaksiController::class, 'exportPdf'])
            ->middleware('menu:/belanja,read')
            ->name('belanja.pdf');
    });

    /**
     * Route profil
     */
    Route::prefix('/profil')->group(function () {
        Route::get('/', [ProfilController::class, 'index'])->name('profil');
    });
});


Route::redirect('/', '/dashboard');


Route::fallback(function () {
    return abort(404);
});
