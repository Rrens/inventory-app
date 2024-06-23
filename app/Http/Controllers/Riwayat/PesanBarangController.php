<?php

namespace App\Http\Controllers\Riwayat;

use App\Http\Controllers\Controller;
use App\Models\PemesananDetail;
use Illuminate\Http\Request;

class PesanBarangController extends Controller
{
    public function index()
    {
        $active = 'pesan-barang';
        $active_group = 'riwayat';

        $data_detail = PemesananDetail::all();

        $value_filter = false;

        return view('website.pages.admin.riwayat.pesan-barang', compact('active', 'active_group', 'data_detail', 'value_filter'));
    }

    public function filter($filter)
    {
        $active = 'pesan-barang';
        $active_group = 'riwayat';

        $data_detail = PemesananDetail::where('date_in', $filter)->get();

        $value_filter = $filter;

        return view('website.pages.admin.riwayat.pesan-barang', compact('active', 'active_group', 'data_detail', 'value_filter'));
    }
}
