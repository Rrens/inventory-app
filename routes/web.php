<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Laporan\PesanPersediaanController;
use App\Http\Controllers\Master\BarangController;
use App\Http\Controllers\Master\SupplierController;
use App\Http\Controllers\Pengelolaan\BarangKeluarController;
use App\Http\Controllers\Pengelolaan\BarangMasukController;
use App\Http\Controllers\Pengelolaan\PermintaanBarangController;
use App\Http\Controllers\Pengelolaan\PesanBarangController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::group([
    'prefix' => 'auth'
], function () {
    Route::get('', [AuthController::class, 'index'])->name('login');
    Route::post('post-login', [AuthController::class, 'post_login'])->name('post-login');
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
});

Route::group([
    'middleware' => ['auth']
], function () {

    Route::redirect('/master', '/master/barang', 301);

    Route::group([
        'prefix' => 'master',
        'middleware' => ['role:admin']
    ], function () {
        Route::group([
            'prefix' => 'barang'
        ], function () {
            Route::get('', [BarangController::class, 'index'])->name('master.barang.index');
            Route::post('', [BarangController::class, 'store'])->name('master.barang.store');
            Route::post('update', [BarangController::class, 'update'])->name('master.barang.update');
            Route::post('delete', [BarangController::class, 'delete'])->name('master.barang.delete');
        });

        Route::group([
            'prefix' => 'supplier',
        ], function () {
            Route::get('', [SupplierController::class, 'index'])->name('master.supplier.index');
            Route::post('', [SupplierController::class, 'store'])->name('master.supplier.store');
            Route::post('update', [SupplierController::class, 'update'])->name('master.supplier.update');
            Route::post('delete', [SupplierController::class, 'delete'])->name('master.supplier.delete');
        });
    });

    Route::group([
        'prefix' => 'pengelolaan',
        'middleware' => ['role:admin']
    ], function () {
        Route::group([
            'prefix' => 'pesan-barang'
        ], function () {
            Route::get('', [PesanBarangController::class, 'index'])->name('pengelolaan.pesan-barang.index');
        });

        Route::group([
            'prefix' => 'barang-masuk'
        ], function () {
            Route::get('', [BarangMasukController::class, 'index'])->name('pengelolaan.barang-masuk.index');
        });

        Route::group([
            'prefix' => 'barang-keluar',
        ], function () {
            Route::get('', [BarangKeluarController::class, 'index'])->name('pengelolaan.barang-keluar.index');
        });
    });

    Route::group([
        'prefix' => 'user-management',
        'middleware' => ['role:owner']
    ], function () {
        Route::get('', [UserController::class, 'index'])->name('user.index');
        Route::post('', [UserController::class, 'store'])->name('user.store');
        Route::post('update', [UserController::class, 'update'])->name('user.update');
        Route::post('delete', [UserController::class, 'delete'])->name('user.delete');
    });

    Route::group([
        'prefix' => 'laporan',
        'middleware' => ['role:owner']
    ], function () {
        Route::get('pesan-persedian', [PesanPersediaanController::class, 'index'])->name('laporan.pesan-pesidaan.index');
    });

    Route::group([
        'prefix' => 'owner-dashboard',
        'middleware' => ['role:owner']
    ], function () {
        Route::get('', [DashboardController::class, 'owner'])->name('dashboard.index');
    });
});
