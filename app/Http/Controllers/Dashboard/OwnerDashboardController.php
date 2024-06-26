<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Pemakaian;
use App\Models\Pemesanan;
use App\Models\PemesananDetail;
use App\Models\Penjualan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OwnerDashboardController extends Controller
{
    public function index()
    {
        $active = 'dashboard';
        $active_group = 'dashboard';

        $logo_verify = $this->logo_verify();
        $logo_warning = $this->logo_warning();
        $logo_danger = $this->logo_danger();

        $total_pemesanan = $this->total_pemesanan();
        $total_barang_masuk = $this->total_barang_masuk();
        $total_barang_keluar = $this->total_barang_keluar();
        $total_persetujuan = $this->total_persetujuan();

        $data = $this->data();
        $value_filter = false;

        return view('website.pages.owner.dashboard', compact(
            'active',
            'active_group',
            'data',
            'logo_verify',
            'logo_warning',
            'logo_danger',
            'total_pemesanan',
            'total_barang_masuk',
            'total_barang_keluar',
            'total_persetujuan',
            'value_filter'
        ));
    }

    public function filter($filter)
    {
        $active = 'dashboard';
        $active_group = 'dashboard';

        $logo_verify = $this->logo_verify();
        $logo_warning = $this->logo_warning();
        $logo_danger = $this->logo_danger();

        $total_pemesanan = $this->total_pemesanan();
        $total_barang_masuk = $this->total_barang_masuk();
        $total_barang_keluar = $this->total_barang_keluar();
        $total_persetujuan = $this->total_persetujuan();

        $data = $this->data($filter);
        $value_filter = $filter;

        return view('website.pages.owner.dashboard', compact(
            'active',
            'active_group',
            'data',
            'logo_verify',
            'logo_warning',
            'logo_danger',
            'total_pemesanan',
            'total_barang_masuk',
            'total_barang_keluar',
            'total_persetujuan',
            'value_filter'
        ));
    }

    public function data($filter = false)
    {
        if ($filter) {
            $data_detail = DB::table('pemesanans as p')
                ->join('pemesanan_details as pd', 'pd.pemesanan_id', '=', 'p.id')
                ->join('barangs as b', 'pd.barang_id', '=', 'b.id')
                ->join('suppliers as s', 's.id', '=', 'pd.supplier_id')
                ->selectRaw('b.id, b.name, pd.quantity, p.slug, pd.eoq, b.quantity as stock, b.leadtime, s.name as supplier_name')
                ->where('b.place', $filter)
                // ->where('p.slug', $slug)
                ->get();
        } else {
            $data_detail = DB::table('pemesanans as p')
                ->join('pemesanan_details as pd', 'pd.pemesanan_id', '=', 'p.id')
                ->join('barangs as b', 'pd.barang_id', '=', 'b.id')
                ->join('suppliers as s', 's.id', '=', 'pd.supplier_id')
                ->selectRaw('b.id, b.name, pd.quantity, p.slug, pd.eoq, b.quantity as stock, b.leadtime, s.name as supplier_name')
                // ->where('p.slug', $slug)
                ->get();
        }

        $bulan_tahun = DB::table('penjualans')
            ->selectRaw('DATE_FORMAT(MAX(order_date),"%m-%Y") as bulan')
            ->whereRaw('DATE_FORMAT(order_date, "%m-%Y") < DATE_FORMAT(now(), "%m-%Y")')
            ->first();

        if (!empty($bulan_tahun->bulan)) {
            $subdate = Carbon::createFromFormat('d-m-Y', '01' . "-" . $bulan_tahun->bulan)->format('Y-m-d H:i:s');
            $lastdate = Carbon::createFromFormat('d-m-Y H:i:s', '01' . "-" . $bulan_tahun->bulan . " 00:00:00")->addDay($this->jumlahHari($bulan_tahun->bulan))->format('Y-m-d H:i:s');
        }

        $no = 1;
        $detail_penjualan = array();
        foreach ($data_detail as $item) {
            if (!empty($bulan_tahun->bulan)) {
                $data = DB::table('penjualans as p')
                    ->join('barangs as b', 'p.barang_id', '=', 'b.id')
                    ->selectRaw('max(p.quantity) as max, round(avg(p.quantity)) as avg, sum(p.quantity) as total')
                    ->whereRaw("b.id = '" . $item->id . "' AND DATE_FORMAT(p.order_date, '%m-%Y') = '" . $bulan_tahun->bulan . "'")
                    ->first();
            } else {
                $data = DB::table('penjualans as p')
                    ->join('barangs as b', 'p.barang_id', '=', 'b.id')
                    ->selectRaw('max(p.quantity) as max, round(avg(p.quantity)) as avg, sum(p.quantity) as total')
                    ->first();
            }

            // dd($data);
            $lead_time = !empty($item->leadtime) ? $item->leadtime : 5;
            $ss = ($data->max - $data->avg) * $lead_time; // SAFETY STOCK
            $jumlah_hari = $this->jumlahHari($bulan_tahun->bulan);
            $d = (int)round($data->total / $jumlah_hari);
            $rop = ($d * $lead_time) + $ss;
            // dd($rop, $d, $ss, $lead_time);

            $temp = (object)[
                'no' => $no++,
                'id' => $item->id,
                'nama_barang' => $item->name,
                'jumlah_pemesanan' => $item->quantity,
                'supplier_name' => $item->supplier_name,
                'stok' => $item->stock,
                'eoq' => $item->eoq,
                'rop' => $rop,
                'max' => $data->max,
                'avg' => $data->avg,
                'sum' => $data->total,
                'd' => $d,
                'lead_time' => $lead_time,
                'ss' => $ss,
            ];

            array_push($detail_penjualan, $temp);
        }

        return $detail_penjualan;
    }

    public function total_pemesanan()
    {
        $total = PemesananDetail::count();
        return $total;
    }

    public function total_barang_masuk()
    {
        $total = PemesananDetail::where('status', true)->count();
        return $total;
    }

    public function total_barang_keluar()
    {
        $total = Penjualan::where('status', true)->count();
        return $total;
    }

    public function total_persetujuan()
    {
        $total = Pemakaian::where('status', true)->count();
        return $total;
    }

    public function logo_verify()
    {
        $logo = '<svg width="30" height="30" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                <rect width="50" height="50" fill="url(#pattern0_574_680)"/>
                <defs>
                <pattern id="pattern0_574_680" patternContentUnits="objectBoundingBox" width="1" height="1">
                <use xlink:href="#image0_574_680" transform="scale(0.01)"/>
                </pattern>
                <image id="image0_574_680" width="100" height="100" xlink:href="data:image/png;base64,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"/>
                </defs>
                </svg>
                ';

        return $logo;
    }

    public function logo_warning()
    {
        $logo = '<svg width="30" height="30" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
            <rect width="50" height="50" fill="url(#pattern0_574_683)"/>
            <defs>
            <pattern id="pattern0_574_683" patternContentUnits="objectBoundingBox" width="1" height="1">
            <use xlink:href="#image0_574_683" transform="scale(0.01)"/>
            </pattern>
            <image id="image0_574_683" width="100" height="100" xlink:href="data:image/png;base64,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"/>
            </defs>
            </svg>
            ';

        return $logo;
    }

    public function logo_danger()
    {
        $logo = '<svg width="30" height="30" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                <rect width="50" height="50" fill="url(#pattern0_1176_3)"/>
                <defs>
                <pattern id="pattern0_1176_3" patternContentUnits="objectBoundingBox" width="1" height="1">
                <use xlink:href="#image0_1176_3" transform="scale(0.01)"/>
                </pattern>
                <image id="image0_1176_3" width="100" height="100" xlink:href="data:image/png;base64,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"/>
                </defs>
                </svg>
                ';

        return $logo;
    }

    public function jumlahHari($bulan_tahun)
    {
        $jumlah = date('t', strtotime(substr($bulan_tahun, 3, 4) . "-" . substr($bulan_tahun, 0, 2) . "-01"));
        return $jumlah;
    }
}
