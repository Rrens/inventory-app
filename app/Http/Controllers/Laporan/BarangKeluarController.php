<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BarangKeluarController extends Controller
{
    public function __construct()
    {
        $active = 'laporan-barang-keluar';
        $active_group = 'laporan';
        return view('website.pages.owner.laporan.barang-masuk', compact('active', 'active_group'));
    }
}
