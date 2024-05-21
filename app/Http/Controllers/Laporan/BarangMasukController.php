<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BarangMasukController extends Controller
{
    public function __construct()
    {
        $active = 'laporan-barang-masuk';
        $active_group = 'laporan';

        return view('website.pages.owner.laporan.barang-masuk', compact('active', 'active_group'));
    }
}