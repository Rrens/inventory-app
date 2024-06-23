<?php

namespace App\Http\Controllers\Riwayat;

use App\Http\Controllers\Controller;
use App\Models\Pemesanan;
use App\Models\PemesananDetail;
use Illuminate\Http\Request;

class BarangMasukController extends Controller
{
    public function index()
    {
        $active = 'barang-masuk';
        $active_group = 'riwayat';

        $data_detail = PemesananDetail::where('status', true)->get();

        $value_filter = false;

        return view('website.pages.admin.riwayat.barang-masuk', compact(
            'active',
            'active_group',
            'data_detail',
            'value_filter'
        ));
    }

    public function filter($filter)
    {
        $active = 'barang-masuk';
        $active_group = 'riwayat';

        $data_detail = PemesananDetail::where('status', true)
            ->where('date_in', $filter)
            ->get();

        $value_filter = $filter;
        return view('website.pages.admin.riwayat.barang-masuk', compact(
            'active',
            'active_group',
            'data_detail',
            'value_filter'
        ));
    }
}
