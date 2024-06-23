<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Models\PemesananDetail;
use Illuminate\Http\Request;

class BarangMasukController extends Controller
{
    public function __construct()
    {
        $active = 'laporan-barang-masuk';
        $active_group = 'laporan';

        $data_detail = PemesananDetail::where('status', true)->get();

        return view('website.pages.owner.laporan.barang-masuk', compact('active', 'active_group', 'data_detail'));
    }
}
