<?php

use App\Http\Controllers\AkunBelanjaController;
use App\Http\Controllers\Arsip\ArsipController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DivisiController;
use App\Http\Controllers\JenisBelanjaController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


/**
 * Redirect
 */
Route::redirect('/', 'dashboard');


/**
 * Route middleware guest
 */
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
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

        Route::get('/chart/{year}', [DashboardController::class, 'globalBudgetChart'])
            ->middleware('menu:/dashboard,read')
            ->name('dashboard.global');

        Route::get('/chart/admin/{divisi}/{year}/divisi', [DashboardController::class, 'budgetChartByDivisi'])
            ->middleware('menu:/dashboard,read')
            ->name('dashboard.divisi');

        Route::get('/chart/admin/akun-belanja', [DashboardController::class, 'budgetChartByAkunBelanja'])
            ->middleware('menu:/dashboard,read')
            ->name('dashboard.admin.jenisBelanja');

        Route::get('/chart/divisi/{year}/jenis-belanja', [DashboardController::class, 'transaksiChartLine'])
            ->middleware('menu:/dashboard,read')
            ->name('dashboard.divisi.jenisBelanja');
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

        Route::get('/{budget}/switch', [BudgetController::class, 'switch'])
            ->middleware('menu:/budget,update')
            ->name('budget.switch');

        Route::patch('/{budget}/switch', [BudgetController::class, 'updateSwitch'])
            ->middleware('menu:/budget,update')
            ->name('budget.switch.update');

        Route::get('/create', [BudgetController::class, 'create'])
            ->middleware('menu:/budget,create')
            ->name('budget.create');

        Route::post('/', [BudgetController::class, 'store'])
            ->middleware('menu:/budget,create')
            ->name('budget.store');

        Route::get('/{budget}/show', [BudgetController::class, 'show'])
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
     * Route akun belanja
     */
    Route::prefix('/akun-belanja')->group(function () {

        /**
         * Route jenis belanja
         */
        Route::prefix('/jenis-belanja')->group(function () {
            Route::get('/', [JenisBelanjaController::class, 'index'])
                ->middleware('menu:/akun-belanja,read')
                ->name('jenis-belanja');

            Route::get('/create', [JenisBelanjaController::class, 'create'])
                ->middleware('menu:/akun-belanja,create')
                ->name('jenis-belanja.create');

            Route::post('/', [JenisBelanjaController::class, 'store'])
                ->middleware('menu:/akun-belanja,create')
                ->name('jenis-belanja.store');

            Route::get('/{jenisBelanja}/edit', [JenisBelanjaController::class, 'edit'])
                ->middleware('menu:/akun-belanja,update')
                ->name('jenis-belanja.edit');

            Route::patch('/{jenisBelanja}', [JenisBelanjaController::class, 'update'])
                ->middleware('menu:/akun-belanja,update')
                ->name('jenis-belanja.update');

            Route::delete('/{jenisBelanja}', [JenisBelanjaController::class, 'delete'])
                ->middleware('menu:/akun-belanja,delete')
                ->name('jenis-belanja.delete');

            Route::get('/datatable', [JenisBelanjaController::class, 'dataTable'])
                ->name('jenis-belanja.datatable');
        });

        /**
         * Route akun belanja
         */
        Route::get('/', [AkunBelanjaController::class, 'index'])
            ->middleware('menu:/akun-belanja,read')
            ->name('akun-belanja');

        Route::get('/create', [AkunBelanjaController::class, 'create'])
            ->middleware('menu:/akun-belanja,create')
            ->name('akun-belanja.create');

        Route::post('/', [AkunBelanjaController::class, 'store'])
            ->middleware('menu:/akun-belanja,create')
            ->name('akun-belanja.store');

        Route::get('/{akunBelanja}/edit', [AkunBelanjaController::class, 'edit'])
            ->middleware('menu:/akun-belanja,update')
            ->name('akun-belanja.edit');

        Route::patch('/{akunBelanja}', [AkunBelanjaController::class, 'update'])
            ->middleware('menu:/akun-belanja,update')
            ->name('akun-belanja.update');

        Route::delete('/{akunBelanja}', [AkunBelanjaController::class, 'delete'])
            ->middleware('menu:/akun-belanja,delete')
            ->name('akun-belanja.delete');
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

        Route::get('/budget/datatable', [TransaksiController::class, 'dataTable'])
            ->middleware('menu:/belanja,read')
            ->name('belanja.datatable.budget');
    });


    /**
     * Route profil
     */
    Route::prefix('/profil')->group(function () {
        Route::get('/', [ProfilController::class, 'index'])
            ->name('profil');

        Route::patch('/', [ProfilController::class, 'updateProfil'])
            ->name('profil.update');

        Route::get('/akun', [ProfilController::class, 'akun'])
            ->name('profil.akun');

        Route::patch('/akun/username', [ProfilController::class, 'updateUsername'])
            ->name('profil.akun.username.update');

        Route::patch('/akun/password', [ProfilController::class, 'updatePassword'])
            ->name('profil.akun.password.update');

        Route::get('/pengaturan', [ProfilController::class, 'pengaturan'])
            ->name('profil.pengaturan');

        Route::patch('/pengaturan/tema', [ProfilController::class, 'updateTema'])
            ->name('profil.pengaturan.tema');
    });

    /**
     * Route group arsip
     */
    Route::prefix('/arsip')->group(function () {

        /**
         * Arsip dokumen
         */
        Route::get('/dokumen', [ArsipController::class, 'index'])
            ->middleware('menu:/arsip/dokumen,read')
            ->name('arsip.dokumen');
    });
});
