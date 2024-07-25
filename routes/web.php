<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Dashboard\AdminDashboardController;
use App\Http\Controllers\Dashboard\OwnerDashboardController;
use App\Http\Controllers\Laporan\BarangKeluarController as LaporanBarangKeluarController;
use App\Http\Controllers\Laporan\BarangMasukController as LaporanBarangMasukController;
use App\Http\Controllers\Laporan\PersetujuanPemakaianBarangController;
use App\Http\Controllers\Laporan\PersetujuanPesanBarangController;
use App\Http\Controllers\Laporan\PesanBarangController as LaporanPesanBarangController;
use App\Http\Controllers\Laporan\PesanPersediaanController;
use App\Http\Controllers\ListrikController;
use App\Http\Controllers\Master\BarangController;
use App\Http\Controllers\Master\SupplierController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Pengelolaan\BarangKeluarController as PengelolaanBarangKeluarController;
use App\Http\Controllers\Pengelolaan\BarangMasukController as PengelolaanBarangMasukController;
use App\Http\Controllers\Pengelolaan\PenjualanController;
use App\Http\Controllers\Pengelolaan\PermintaanBarangController;
use App\Http\Controllers\Pengelolaan\PesanBarangController;
use App\Http\Controllers\Persetujuan\PemakaianController;
use App\Http\Controllers\Persetujuan\PesanPersediaanController as PersetujuanPesanPersediaanController;
use App\Http\Controllers\Riwayat\BarangMasukController as RiwayatBarangMasukController;
use App\Http\Controllers\Riwayat\PesanBarangController as RiwayatPesanBarangController;
use App\Http\Controllers\Riwayat\BarangKeluarController as RiwayatBarangKeluarController;
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

    Route::prefix('listrik')->group(function () {
        Route::get('', [ListrikController::class, 'update'])->name('listrik.update');
    });

    Route::prefix('master')->group(function () {
        Route::prefix('barang')->group(function () {
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
    });

    Route::prefix('riwayat')->group(function () {
        Route::prefix('penjualan-barang')->group(function () {
            Route::get('', [RiwayatPesanBarangController::class, 'index'])->name('riwayat.pesan-barang.index');
            Route::get('{filter}', [RiwayatPesanBarangController::class, 'filter'])->name('riwayat.pesan-barang.filter');
        });
        Route::prefix('barang-masuk')->group(function () {
            Route::get('', [RiwayatBarangMasukController::class, 'index'])->name('riwayat.barang-masuk.index');
            Route::get('{filter}', [RiwayatBarangMasukController::class, 'filter'])->name('riwayat.barang-masuk.filter');
        });
        Route::prefix('penjualan')->group(function () {
            Route::get('', [RiwayatBarangKeluarController::class, 'index'])->name('riwayat.barang-keluar.index');
            Route::get('{filter}', [RiwayatBarangKeluarController::class, 'filter'])->name('riwayat.barang-keluar.filter');
        });
    });

    Route::prefix('pengelolaan')->group(function () {
        Route::prefix('penjualan-barang')->group(function () {
            Route::get('', [PesanBarangController::class, 'index'])->name('pengelolaan.pesan-barang.index');
            Route::post('', [PesanBarangController::class, 'store'])->name('pengelolaan.pesan-barang.store');
            Route::post('add-cart', [PesanBarangController::class, 'store_cart'])->name('pengelolaan.pesan-barang.store-cart');
            Route::post('update-cart', [PesanBarangController::class, 'update_cart'])->name('pengelolaan.pesan-barang.update-cart');
            Route::post('delete-cart', [PesanBarangController::class, 'delete_cart'])->name('pengelolaan.pesan-barang.delete-cart');
            Route::post('count-eoq',  [PesanBarangController::class, 'count_eoq']);
            Route::get('check-stock/{id_barang}',  [PesanBarangController::class, 'checkStock']);
        });

        Route::prefix('barang-masuk')->group(function () {
            Route::get('', [PengelolaanBarangMasukController::class, 'index'])->name('pengelolaan.barang-masuk.index');
            Route::post('', [PengelolaanBarangMasukController::class, 'barang_masuk_selesai'])->name('pengelolaan.barang-masuk.barang_masuk_selesai');
        });

        Route::prefix('barang-keluar')->group(function () {
            Route::get('', [PengelolaanBarangKeluarController::class, 'index'])->name('pengelolaan.barang-keluar.index');
            Route::post('', [PengelolaanBarangKeluarController::class, 'store'])->name('pengelolaan.barang-keluar.store');
            Route::get('check-stock/{id}/{place}',  [PengelolaanBarangKeluarController::class, 'checkStock']);
            Route::get('check-safety-stock/{id}', [PengelolaanBarangKeluarController::class, 'checkSafetyStock']);
        });

        Route::prefix('penjualan')->group(function () {
            Route::get('', [PenjualanController::class, 'index'])->name('pengelolaan.penjualan.index');
            Route::post('store-cart', [PenjualanController::class, 'store_cart'])->name('pengelolaan.penjualan.store-cart');
            Route::post('update-cart', [PenjualanController::class, 'update_cart'])->name('pengelolaan.penjualan.update-cart');
            Route::post('delete-cart', [PenjualanController::class, 'delete_cart'])->name('pengelolaan.penjualan.delete-cart');
            Route::post('store', [PenjualanController::class, 'store'])->name('pengelolaan.penjualan.store');
            Route::get('check-stock/{id}',  [PenjualanController::class, 'checkStock']);
            Route::get('check-safety-stock/{id}', [PenjualanController::class, 'checkSafetyStock']);
            Route::get('check-cart-stock/{barang_id}', [PenjualanController::class, 'checkQuantityCart']);
            Route::get('check-if-closest-rop-value/{id}', [PenjualanController::class, 'checkIfClosestRopValue']);
        });
    });

    Route::prefix('admin-dashboard')->group(function () {
        Route::get('', [AdminDashboardController::class, 'index'])->name('admin.dashboard.index');
        Route::get('{filter}', [AdminDashboardController::class, 'filter'])->name('admin.dashboard.filter');
    });
});

Route::middleware(['auth', 'role:owner'])->group(function () {
    Route::prefix('user-management')->group(function () {
        Route::get('', [UserController::class, 'index'])->name('user.index');
        Route::post('', [UserController::class, 'store'])->name('user.store');
        Route::post('update', [UserController::class, 'update'])->name('user.update');
        Route::post('delete', [UserController::class, 'delete'])->name('user.delete');
    });

    Route::prefix('persetujuan')->group(function () {
        Route::prefix('pesan-persetujuan')->group(function () {
            Route::get('', [PersetujuanPesanPersediaanController::class, 'index'])->name('persetujuan.pesan-persetujuan.index');
            Route::get('detail/{slug}', [PersetujuanPesanPersediaanController::class, 'detail'])->name('persetujuan.pesan-persetujuan.detail');
            Route::get('change-verify/{status}/{id}/{id_barang}', [PersetujuanPesanPersediaanController::class, 'action_verif_or_not'])->name('persetujuan.pesan-persetujuan.action_verif_or_not');
        });

        Route::prefix('pemakaian')->group(function () {
            Route::get('', [PemakaianController::class, 'index'])->name('pesetujuan.pemakaian.index');
            Route::post('', [PemakaianController::class, 'store'])->name('persetujuan.pemakaian.store');
        });
    });

    Route::prefix('laporan')->group(function () {
        Route::prefix('penjualan-barang')->group(function () {
            Route::get('', [LaporanPesanBarangController::class, 'index'])->name('laporan.pesan-barang.index');
            Route::get('{filter}', [LaporanPesanBarangController::class, 'filter'])->name('laporan.pesan-barang.filter');
        });
        Route::prefix('barang-masuk')->group(function () {
            Route::get('', [LaporanBarangMasukController::class, 'index'])->name('laporan.barang-masuk.index');
            Route::get('{filter}', [LaporanBarangMasukController::class, 'filter'])->name('laporan.barang-masuk.filter');
        });
        // Route::get('barang-masuk', [LaporanBarangMasukController::class, '__construct'])->name('laporan.barang-masuk.index');
        Route::prefix('penjualan')->group(function () {
            Route::get('', [LaporanBarangKeluarController::class, 'index'])->name('laporan.barang-keluar.index');
            Route::get('{filter}', [LaporanBarangKeluarController::class, 'filter'])->name('laporan.barang-keluar.filter');
        });
        // Route::get('barang-keluar', [LaporanBarangKeluarController::class, '__construct'])->name('laporan.barang-keluar.index');
        Route::prefix('penjualan-persediaan')->group(function () {
            Route::get('', [PesanPersediaanController::class, 'index'])->name('laporan.pesan-persediaan.index');
            Route::get('{filter}', [PesanPersediaanController::class, 'filter'])->name('laporan.pesan-persediaan.filter');
        });

        Route::prefix('persetujuan-barang')->group(function () {
            Route::get('', [PersetujuanPemakaianBarangController::class, 'index'])->name('laporan.persetujuan-pemakian.index');
            Route::get('{date}', [PersetujuanPemakaianBarangController::class, 'filter'])->name('laporan.persetujuan-pemakian.filter');
        });

        Route::prefix('persetujuan-pesan-barang')->group(function () {
            Route::get('', [PersetujuanPesanBarangController::class, 'index'])->name('laporan.persetujuan-pesan-barang.index');
            Route::get('{date}', [PersetujuanPesanBarangController::class, 'filter'])->name('laporan.persetujuan-pesan-barang.filter');
        });
    });

    Route::prefix('owner-dashboard')->group(function () {
        Route::get('', [OwnerDashboardController::class, 'index'])->name('owner.dashboard.index');
        Route::get('{filter}', [OwnerDashboardController::class, 'filter'])->name('owner.dashboard.filter');
    });
});

Route::get('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notification.read')->middleware('auth');
