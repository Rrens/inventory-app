<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('website.pages.admin.master.barang');
});
