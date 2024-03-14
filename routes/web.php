<?php

use App\Http\Controllers\Master\BarangController;
use App\Http\Controllers\Master\SupplierController;
use App\Http\Controllers\Pengelolaan\PesanBarangController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('website.pages.admin.master.barang');
// });

Route::redirect('/', '/master/barang', 301);

Route::group([
    'prefix' => 'master',
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
    });
});

Route::group([
    'prefix' => 'pengelolaan',
], function () {
    Route::group([
        'prefix' => 'pesan-barang'
    ], function () {
        Route::get('', [PesanBarangController::class, 'index'])->name('pengelolaan.pesan-barang.index');
    });
});
