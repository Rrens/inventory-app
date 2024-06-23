<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Models\PemesananDetail;
use Illuminate\Http\Request;

class PesanBarangController extends Controller
{
    public function __construct()
    {
        $active = 'pesan-barang';
        $active_group = 'laporan';
        // $data = PemesananDetail::where('status', true)->get();
        $data = PemesananDetail::whereHas('pemesanan', function ($query) {
            $query->where('is_verify', true);
        })->get();
        return view('website.pages.owner.laporan.pesan-barang', compact('active', 'active_group', 'data'));
    }
}
