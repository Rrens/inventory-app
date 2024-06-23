<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Models\Penjualan;
use Illuminate\Http\Request;

class BarangKeluarController extends Controller
{
    public function index()
    {
        $active = 'laporan-barang-keluar';
        $active_group = 'laporan';

        $data_detail = Penjualan::where('status', true)->get();
        $value_filter = false;
        return view('website.pages.owner.laporan.barang-keluar', compact(
            'active',
            'active_group',
            'data_detail',
            'value_filter'
        ));
    }

    public function filter($filter)
    {
        $active = 'laporan-barang-keluar';
        $active_group = 'laporan';

        $data_detail = Penjualan::where('status', true)
            ->whereDate('order_date', $filter)
            ->get();
        $value_filter = $filter;
        return view('website.pages.owner.laporan.barang-keluar', compact(
            'active',
            'active_group',
            'data_detail',
            'value_filter'
        ));
    }
}
