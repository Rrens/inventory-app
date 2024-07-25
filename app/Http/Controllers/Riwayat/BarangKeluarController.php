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
        $active = 'riwayat-barang-keluar';
        $active_group = 'riwayat';
        $data_detail = Penjualan::where('status', false)->get();
        $value_filter = false;
        return view('website.pages.admin.riwayat.barang-keluar', compact(
            'active',
            'active_group',
            'data_detail',
            'value_filter'
        ));
    }

    public function filter($filter)
    {
        $active = 'barang-keluar';
        $active_group = 'riwayat';
        $data_detail = Penjualan::where('status', false)
            ->whereDate('updated_at', $filter)
            ->get();
        $value_filter = $filter;
        return view('website.pages.admin.riwayat.barang-keluar', compact(
            'active',
            'active_group',
            'data_detail',
            'value_filter'
        ));
    }
}
