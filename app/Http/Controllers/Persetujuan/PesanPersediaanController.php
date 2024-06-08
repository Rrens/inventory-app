<?php

namespace App\Http\Controllers\Persetujuan;

use App\Http\Controllers\Controller;
use App\Models\Pemesanan;
use App\Models\PemesananDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class PesanPersediaanController extends Controller
{
    public function index()
    {
        $active = 'pesan-persediaan';
        $active_group = 'persetujuan';

        $data = Pemesanan::all();
        return view('website.pages.owner.persetujuan.pesan-persediaan', compact('active', 'active_group', 'data'));
    }

    public function detail($slug)
    {
        $active = 'pesan-persediaan';
        $active_group = 'persetujuan';
        // dd($slug);

        $data = Pemesanan::where('slug', $slug)->first();
        $pemesanan_id = $data->pemesanan_id;

        $data_detail = DB::table('pemesanans as p')
            ->join('pemesanan_details as pd', 'pd.pemesanan_id', '=', 'p.id')
            ->join('barangs as b', 'pd.barang_id', '=', 'b.id')
            ->selectRaw('b.id, b.name, pd.quantity, p.slug, pd.eoq, b.quantity as stock')
            ->where('p.slug', $slug)
            ->get();

        $bulan_tahun = DB::table('penjualans')
            ->selectRaw('DATE_FORMAT(MAX(order_date),"%m-%Y") as bulan')
            ->whereRaw('DATE_FORMAT(order_date, "%m-%Y") < DATE_FORMAT(now(), "%m-%Y")')
            ->first();
        // dd($bulan_tahun, '09-2024' < '05-2024');

        $subdate = Carbon::createFromFormat('d-m-Y', '01' . "-" . $bulan_tahun->bulan)->format('Y-m-d H:i:s');
        $lastdate = Carbon::createFromFormat('d-m-Y H:i:s', '01' . "-" . $bulan_tahun->bulan . " 00:00:00")->addDay($this->jumlahHari($bulan_tahun->bulan))->format('Y-m-d H:i:s');

        $avg_date = DB::table('pemesanans as p')
            ->join('persediaan_masuks as pm', 'p.pemesanan_id', '=', 'pm.pemesanan_id')
            ->selectRaw('round(avg(DATEDIFF( pm.persediaan_masuk_date, p.created_at))) as lead_time')
            ->where('p.status', 'Selesai')
            ->whereBetween('pm.persediaan_masuk_date', [$subdate, $lastdate])
            ->first();

        $no = 1;
        $detail_penjualan = array();
        foreach ($data_detail as $item) {
            $data = DB::table('penjualan_details as pd')
                ->join('penjualans as p', 'pd.penjualan_id', '=', 'p.penjualan_id')
                ->join('barangs as b', 'pd.barang_id', '=', 'b.id')
                ->selectRaw('max(pd.quantity) as max, round(avg(pd.quantity)) as avg, sum(pd.quantity) as total')
                ->whereRaw("b.id = '" . $item->id . "' AND DATE_FORMAT(p.order_date, '%m-%Y') = '" . $bulan_tahun->bulan . "'")
                ->first();
            // dd($data);
            $lead_time = !empty($avg_date->lead_time) ? $avg_date->lead_time : 2;
            $ss = ($data->max - $data->avg) * $lead_time;
            $jumlah_hari = $this->jumlahHari($bulan_tahun->bulan);
            $d = (int)round($data->total / $jumlah_hari);
            $rop = ($d * $lead_time) + $ss;

            $temp = (object)[
                'no' => $no++,
                'barang_id' => $item->id,
                'nama_barang' => $item->name,
                'jumlah_pemesanan' => $item->quantity,
                'stok' => $item->stock,
                'eoq' => $item->eoq,
                'rop' => $rop,
                'max' => $data->max,
                'avg' => $data->avg,
                'sum' => $data->total,
                'd' => $d,
                'lead_time' => $lead_time,
                'ss' => $ss
            ];

            array_push($detail_penjualan, $temp);
        }
        // dd($detail_penjualan);

        return view('website.pages.owner.persetujuan.pesan-persediaan-detail', compact(
            'active',
            'active_group',
            'data',
            'detail_penjualan',
            'pemesanan_id'
        ));
    }

    public function action_verif_or_not(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:pemesanans,id',
            'status' => 'required|in:decline,acc'
        ]);

        if ($validator->fails()) {
            Alert::toast($validator->messages()->all(), 'error');
            return back();
        }

        $data = Pemesanan::findOrFail($request->id);
        if ($request->status == 'decline') {
            $data->is_verify = false;
        } else {
            $data->is_verify = true;
        }
        $data->save();

        Alert::toast('Sukses Menyimpan data', 'success');
        return back();
    }

    public function jumlahHari($bulan_tahun)
    {
        # code...
        $jumlah = date('t', strtotime(substr($bulan_tahun, 3, 4) . "-" . substr($bulan_tahun, 0, 2) . "-01"));
        return $jumlah;
    }
}
