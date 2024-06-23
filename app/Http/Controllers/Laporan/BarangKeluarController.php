<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Models\Penjualan;
use Illuminate\Http\Request;

class BarangKeluarController extends Controller
{
    public function __construct()
    {
        $active = 'laporan-barang-keluar';
        $active_group = 'laporan';

        $data_detail = Penjualan::where('status', true)->get();

        return view('website.pages.owner.laporan.barang-keluar', compact('active', 'active_group', 'data_detail'));
    }
}
