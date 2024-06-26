<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Models\Pemakaian;
use Illuminate\Http\Request;

class PersetujuanPesanBarangController extends Controller
{
    public function index()
    {
        $active = 'laporan-persetujuan-pesan-barang';
        $active_group = 'laporan';

        $data = $this->data();

        $value_filter = false;

        return view('website.pages.owner.laporan.persetujuan-pemakaian', compact('active', 'active_group', 'data', 'value_filter'));
    }

    public function filter($date)
    {
        $active = 'laporan-persetujuan-pesan-barang';
        $active_group = 'laporan';

        $data = $this->data($date);

        $value_filter = $date;

        return view('website.pages.owner.laporan.persetujuan-pemakaian', compact('active', 'active_group', 'data', 'value_filter'));
    }

    public function data($date = null)
    {
        if ($date == null) {
            $data = Pemakaian::where('status', '!=', null)->get();
        } else {
            $data = Pemakaian::whereHas('penjualan', function ($query) use ($date) {
                $query->whereDate('order_date', $date);
            })->get();
        }

        return $data;
    }
}
