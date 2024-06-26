<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Models\PemesananDetail;
use Illuminate\Http\Request;

class PersetujuanPemakaianBarangController extends Controller
{
    public function index()
    {
        $active = 'laporan-persetujuan-pemakaian';
        $active_group = 'laporan';

        $data = $this->data();

        $value_filter = false;

        return view('website.pages.owner.laporan.persetujuan-barang', compact(
            'active',
            'active_group',
            'data',
            'value_filter'
        ));
    }

    public function filter($date)
    {
        $active = 'laporan-persetujuan-pemakaian';
        $active_group = 'laporan';

        $data = $this->data($date);
        // dd($data);

        $value_filter = $date;

        return view('website.pages.owner.laporan.persetujuan-barang', compact(
            'active',
            'active_group',
            'data',
            'value_filter'
        ));
    }

    public function data($date = null)
    {
        if ($date == null) {
            $data = PemesananDetail::all();
        } else {
            $data = PemesananDetail::whereHas('pemesanan', function ($query) use ($date) {
                $query->whereDate('order_date', $date);
            })->get();
        }

        return $data;
    }
}
