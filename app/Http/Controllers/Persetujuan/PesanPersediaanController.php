<?php

namespace App\Http\Controllers\Persetujuan;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Notification;
use App\Models\Pemesanan;
use App\Models\PemesananDetail;
use App\Models\Penjualan;
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

        $data = Pemesanan::orderByRaw('is_verify IS NULL DESC')
            ->orderBy('created_at', 'desc')
            ->get();
        // dd($data);
        return view('website.pages.owner.persetujuan.pesan-persediaan', compact('active', 'active_group', 'data'));
    }

    public function detail($slug)
    {
        $active = 'pesan-persediaan';
        $active_group = 'persetujuan';
        // dd($slug);

        $data_pemesanan = Pemesanan::where('slug', $slug)->first();
        $pemesanan_id = $data_pemesanan->pemesanan_id;

        $data_detail = DB::table('pemesanans as p')
            ->join('pemesanan_details as pd', 'pd.pemesanan_id', '=', 'p.id')
            ->join('barangs as b', 'pd.barang_id', '=', 'b.id')
            ->join('suppliers as s', 's.id', '=', 'pd.supplier_id')
            ->selectRaw('b.id, b.name, pd.quantity, p.slug, pd.eoq, b.quantity as stock, b.leadtime, s.name as supplier_name, pd.order_cost')
            ->where('p.slug', $slug)
            ->get();

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
            $lead_time = !empty($item->leadtime) ? $item->leadtime : 5;
            $ss = ($data->max - $data->avg) * $lead_time;
            $jumlah_hari = $this->jumlahHari($bulan_tahun->bulan);
            $d = (int)round($data->total / $jumlah_hari);
            $rop = ($d * $lead_time) + $ss;

            $temp = (object)[
                'no' => $no++,
                'barang_id' => $item->id,
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
                'order_cost' => $item->order_cost,
            ];
            // dd($temp);

            array_push($detail_penjualan, $temp);
        }
        // dd($data_detail);

        return view('website.pages.owner.persetujuan.pesan-persediaan-detail', compact(
            'active',
            'active_group',
            'data_pemesanan',
            'detail_penjualan',
            'pemesanan_id'
        ));
    }

    public function action_verif_or_not($status, $id, $id_barang)
    {
        // $validator = Validator::make([$status, $id], [
        //     'id' => 'required|exists:pemesanans,id',
        //     'status' => 'required|in:decline,acc'
        // ]);

        // if ($validator->fails()) {
        //     Alert::toast($validator->messages()->all(), 'error');
        //     dd($validator->messages()->all(), $status, $id);
        //     return back();
        // }

        if (empty($status)) {
            Alert::toast('The status field is required.', 'error');
            return back();
        }

        if (empty($id)) {
            Alert::toast('The slug field is required.', 'error');
            return back();
        }

        $data = Pemesanan::where('pemesanan_id', $id)->first();
        if (empty($data)) {
            Alert::toast('Data not found.', 'error');
            return back();
        }
        if ($status == 'decline') {
            $data->is_verify = false;
        } else {
            $data->is_verify = true;
        }
        $data->save();

        // $data_detail = PemesananDetail::where('pemesanan_id', $data->id)->get();
        $data_detail = DB::table('pemesanans as p')
            ->join('pemesanan_details as pd', 'pd.pemesanan_id', '=', 'p.id')
            ->join('barangs as b', 'pd.barang_id', '=', 'b.id')
            ->join('suppliers as s', 's.id', '=', 'pd.supplier_id')
            ->selectRaw('b.id, b.name, pd.quantity, p.slug, pd.eoq, b.quantity as stock, b.leadtime, s.name as supplier_name')
            ->where('p.id', $data->id)
            ->get();

        $bulan_tahun = DB::table('penjualans')
            ->selectRaw('DATE_FORMAT(MAX(order_date),"%m-%Y") as bulan')
            ->whereRaw('DATE_FORMAT(order_date, "%m-%Y") < DATE_FORMAT(now(), "%m-%Y")')
            ->first();
        // dd($data_detail, $id);

        // GAE NGECEK

        $item_gae_cek = $data_detail[0];

        if (!empty($bulan_tahun->bulan)) {
            $data_penjualan = DB::table('penjualans as p')
                ->join('barangs as b', 'p.barang_id', '=', 'b.id')
                ->selectRaw('max(p.quantity) as max, round(avg(p.quantity)) as avg, sum(p.quantity) as total')
                ->whereRaw("b.id = '" . $item_gae_cek->id . "' AND DATE_FORMAT(p.order_date, '%m-%Y') = '" . $bulan_tahun->bulan . "'")
                ->first();
        } else {
            $data_penjualan = DB::table('penjualans as p')
                ->join('barangs as b', 'p.barang_id', '=', 'b.id')
                ->selectRaw('max(p.quantity) as max, round(avg(p.quantity)) as avg, sum(p.quantity) as total')
                ->first();
        }

        $lead_time = !empty($item_gae_cek->leadtime) ? $item_gae_cek->leadtime : 5;
        $ss = ($data_penjualan->max - $data_penjualan->avg) * $lead_time;
        $jumlah_hari = $this->jumlahHari($bulan_tahun->bulan);
        $d = (int)round($data_penjualan->total / $jumlah_hari);
        $rop = ($d * $lead_time) + $ss;
        // dd(['Lead Time' => $lead_time, 'SS' => $ss, 'Demand' => $d]);

        foreach ($data_detail as $item) {

            if (!empty($bulan_tahun->bulan)) {
                $data_penjualan = DB::table('penjualans as p')
                    ->join('barangs as b', 'p.barang_id', '=', 'b.id')
                    ->selectRaw('max(p.quantity) as max, round(avg(p.quantity)) as avg, sum(p.quantity) as total')
                    ->whereRaw("b.id = '" . $item->id . "' AND DATE_FORMAT(p.order_date, '%m-%Y') = '" . $bulan_tahun->bulan . "'")
                    ->first();
            } else {
                $data_penjualan = DB::table('penjualans as p')
                    ->join('barangs as b', 'p.barang_id', '=', 'b.id')
                    ->selectRaw('max(p.quantity) as max, round(avg(p.quantity)) as avg, sum(p.quantity) as total')
                    ->first();
            }

            // $data_penjualan = Penjualan::where('barang_id', $item->id)->where('status', true)->first();
            // $data_penjualan->status = false;
            // $data_penjualan->save();


            $lead_time = !empty($item->leadtime) ? $item->leadtime : 5;
            $ss = ($data_penjualan->max - $data_penjualan->avg) * $lead_time;
            $jumlah_hari = $this->jumlahHari($bulan_tahun->bulan);
            $d = (int)round($data_penjualan->total / $jumlah_hari);
            $rop = ($d * $lead_time) + $ss;
            $change_quantiy = Barang::findOrFail($item->id);
            // $change_quantiy->quantity += $item->quantity;
            $change_quantiy->rop = $rop;
            $change_quantiy->save();

            $barang = Barang::where('id', $item->id)->pluck('name');
            // dd($barang[0]);
            $notification = new Notification();
            $notification->title = "Permintaan Persetujuan Persan {$barang[0]} Disetujui oleh Owner";
            $notification->role = 'admin';
            $notification->link = route('riwayat.pesan-barang.index');
            $notification->save();
        }


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
