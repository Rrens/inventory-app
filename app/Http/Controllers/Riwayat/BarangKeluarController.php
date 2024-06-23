<?php

namespace App\Http\Controllers\Riwayat;

use App\Http\Controllers\Controller;
use App\Models\Penjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarangKeluarController extends Controller
{
    public function index()
    {
        $active = 'barang-keluar';
        $active_group = 'riwayat';
        $data_detail = Penjualan::where('status', true)->get();
        return view('website.pages.admin.riwayat.barang-keluar', compact(
            'active',
            'active_group',
            'data_detail'
        ));
    }
}
