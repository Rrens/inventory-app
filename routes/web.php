<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Laporan\BarangKeluarController as LaporanBarangKeluarController;
use App\Http\Controllers\Laporan\BarangMasukController as LaporanBarangMasukController;
use App\Http\Controllers\Laporan\PesanPersediaanController;
use App\Http\Controllers\Master\BarangController;
use App\Http\Controllers\Master\SupplierController;
use App\Http\Controllers\Pengelolaan\BarangKeluarController;
use App\Http\Controllers\Pengelolaan\BarangMasukController;
use App\Http\Controllers\Pengelolaan\PermintaanBarangController;
use App\Http\Controllers\Pengelolaan\PesanBarangController;
use App\Http\Controllers\Persetujuan\PemakaianController;
use App\Http\Controllers\Persetujuan\PesanPersediaanController as PersetujuanPesanPersediaanController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

if (!Auth::check()) {
    Route::redirect('/', 'auth');
}

Route::prefix('auth')->group(function () {
    Route::get('', [AuthController::class, 'index'])->name('login');
    Route::post('post-login', [AuthController::class, 'post_login'])->name('post-login');
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
});

Route::redirect('/master', '/master/barang', 301);

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::prefix('master')->group(function () {
        Route::get('', [BarangController::class, 'index'])->name('master.barang.index');
        Route::post('', [BarangController::class, 'store'])->name('master.barang.store');
        Route::post('update', [BarangController::class, 'update'])->name('master.barang.update');
        Route::post('delete', [BarangController::class, 'delete'])->name('master.barang.delete');
    });

    Route::prefix('suppplier')->group(function () {
        Route::get('', [SupplierController::class, 'index'])->name('master.supplier.index');
        Route::post('', [SupplierController::class, 'store'])->name('master.supplier.store');
        Route::post('update', [SupplierController::class, 'update'])->name('master.supplier.update');
        Route::post('delete', [SupplierController::class, 'delete'])->name('master.supplier.delete');
    });

    Route::prefix('pengelolaan')->group(function () {
        Route::prefix('pesan-barang')->group(function () {
            Route::get('', [PesanBarangController::class, 'index'])->name('pengelolaan.pesan-barang.index');
            Route::post('', [PesanBarangController::class, 'store'])->name('pengelolaan.pesan-barang.store');
            Route::post('add-cart', [PesanBarangController::class, 'store_cart'])->name('pengelolaan.pesan-barang.store-cart');
            Route::post('update-cart', [PesanBarangController::class, 'update_cart'])->name('pengelolaan.pesan-barang.update-cart');
            Route::post('delete-cart', [PesanBarangController::class, 'delete_cart'])->name('pengelolaan.pesan-barang.delete-cart');
            Route::post('count-eoq',  [PesanBarangController::class, 'count_eoq']);
            Route::get('check-stock/{id_barang}',  [PesanBarangController::class, 'checkStock']);
        });

        Route::prefix('barang-masuk')->group(function () {
            Route::get('', [BarangMasukController::class, 'index'])->name('pengelolaan.barang-masuk.index');
            Route::post('', [BarangMasukController::class, 'barang_masuk_selesai'])->name('pengelolaan.barang-masuk.barang_masuk_selesai');
        });

        Route::prefix('barang-keluar')->group(function () {
            Route::get('', [BarangKeluarController::class, 'index'])->name('pengelolaan.barang-keluar.index');
        });
    });
});

Route::middleware(['auth', 'role:owner'])->group(function () {
    Route::prefix('user-management')->group(function () {
        Route::get('', [UserController::class, 'index'])->name('user.index');
        Route::post('', [UserController::class, 'store'])->name('user.store');
        Route::post('update', [UserController::class, 'update'])->name('user.update');
        Route::post('delete', [UserController::class, 'delete'])->name('user.delete');
    });

    Route::prefix('laporan')->group(function () {
        Route::get('pesan-persedian', [PesanPersediaanController::class, 'index'])->name('laporan.pesan-persediaan.index');
        Route::get('barang-masuk', [LaporanBarangMasukController::class, '__construct'])->name('laporan.barang-masuk.index');
        Route::get('barang-keluar', [LaporanBarangKeluarController::class, '__construct'])->name('laporan.barang-keluar.index');
    });

    Route::prefix('persetujuan')->group(function () {
        Route::prefix('pesan-persetujuan')->group(function () {
            Route::get('', [PersetujuanPesanPersediaanController::class, 'index'])->name('persetujuan.pesan-persetujuan.index');
            Route::get('detail/{slug}', [PersetujuanPesanPersediaanController::class, 'detail'])->name('persetujuan.pesan-persetujuan.detail');
            Route::get('change-verify/{status}/{id}', [PersetujuanPesanPersediaanController::class, 'action_verif_or_not'])->name('persetujuan.pesan-persetujuan.action_verif_or_not');
        });

        Route::prefix('pemakaian')->group(function () {
            Route::get('', [PemakaianController::class, 'index'])->name('pesetujuan.pemakaian.index');
        });
    });

    Route::prefix('owner-dashboard')->group(function () {
        Route::get('', [DashboardController::class, 'owner'])->name('dashboard.index');
    });
});
