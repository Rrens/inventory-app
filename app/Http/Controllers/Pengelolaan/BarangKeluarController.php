<?php

namespace App\Http\Controllers\Pengelolaan;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Notification;
use App\Models\Pemakaian;
use App\Models\Pemesanan;
use App\Models\Penjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BarangKeluarController extends Controller
{
    public function index()
    {
        $active = 'barang-keluar';
        $active_group = 'pengelolaan';

        $products = Barang::groupBy('name')->get();
        return view('website.pages.admin.pengelolaan.barang-keluar', compact('active', 'active_group', 'products'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'barang_id' => 'required|exists:barangs,id',
            'quantity' => "required",
            'value_stock' => 'required|in:true,false',
            'order_date' => 'required|date'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages()->all());
        }

        if ($request->value_stock == 'false') {
            $data = new Penjualan();
            $data->penjualan_id = Penjualan::generateID();
            $data->slug = Penjualan::generateSLUG();
            $data->barang_id = $request->barang_id;
            $data->quantity = $request->quantity;
            $data->order_date = $request->order_date;
            $data->status = false;
            $data->save();
        } else {
            $data = new Penjualan();
            $data->penjualan_id = Penjualan::generateID();
            $data->slug = Penjualan::generateSLUG();
            $data->barang_id = $request->barang_id;
            $data->quantity = $request->quantity;
            $data->order_date = $request->order_date;
            $data->status = true;
            $data->save();

            $notification = new Notification();
            $notification->title = "Permintaan Persetujuan Pemakaian {$data->barang[0]->name} oleh Admin";
            $notification->role = 'owner';
            $notification->link = route('pesetujuan.pemakaian.index');
            $notification->save();

            $notification = new Notification();
            $notification->title = "Stok {$data->barang[0]->name} Telah Mencapai Batas Minimal, Segera Lakukan Pemesanan Pada Supplier";
            $notification->role = 'admin';
            $notification->link = route('pengelolaan.pesan-barang.index');
            $notification->save();

            $pemakaian = new Pemakaian();
            $pemakaian->penjualan_id = $data->penjualan_id;
            $pemakaian->save();
        }

        return response()->json($request);
    }

    public function checkStock($id, $place)
    {
        // return response($id);
        $data = Barang::where('id', $id)
            ->where('place', $place)
            ->pluck('quantity');
        if (!empty($data[0])) {
            return response()->json($data[0]);
        } else {
            return response()->json('data tidak ditemukan');
        }
    }

    public function checkSafetyStock($productID)
    {
        $bulan_tahun = DB::table('penjualans')
            ->selectRaw('DATE_FORMAT(MAX(order_date),"%m-%Y") as bulan')
            ->whereRaw('DATE_FORMAT(order_date, "%m-%Y") < DATE_FORMAT(now(), "%m-%Y")')
            ->first();

        if (!empty($bulan_tahun->bulan)) {
            // $data = DB::table('penjualan_details as pd')
            //     ->join('penjualans as p', 'pd.penjualan_id', '=', 'p.penjualan_id')
            //     ->join('barangs as b', 'pd.barang_id', '=', 'b.id')
            //     ->selectRaw('max(pd.quantity) as max, round(avg(pd.quantity)) as avg, sum(pd.quantity) as total, b.leadtime')
            //     ->whereRaw("b.id = '" . $productID . "' AND DATE_FORMAT(p.order_date, '%m-%Y') = '" . $bulan_tahun->bulan . "'")
            //     ->first();

            $data = DB::table('penjualans as p')
                ->join('barangs as b', 'p.barang_id', '=', 'b.id')
                ->selectRaw('max(p.quantity) as max, round(avg(p.quantity)) as avg, sum(p.quantity) as total, b.leadtime')
                ->whereRaw("b.id = '" . $productID . "' AND DATE_FORMAT(p.order_date, '%m-%Y') = '" . $bulan_tahun->bulan . "'")
                ->first();
        } else {
            // $data = DB::table('penjualan_details as pd')
            //     ->join('penjualans as p', 'pd.penjualan_id', '=', 'p.penjualan_id')
            //     ->join('barangs as b', 'pd.barang_id', '=', 'b.id')
            //     ->selectRaw('max(pd.quantity) as max, round(avg(pd.quantity)) as avg, sum(pd.quantity) as total, b.leadtime')
            //     ->first();

            $data = DB::table('penjualans as p')
                ->join('barangs as b', 'p.barang_id', '=', 'b.id')
                ->selectRaw('max(b.quantity) as max, round(avg(b.quantity)) as avg, sum(b.quantity) as total, b.leadtime')
                ->first();
        }

        $lead_time = !empty($data->leadtime) ? $data->leadtime : 5;
        $ss = ($data->max - $data->avg) * $lead_time;
        // dd($ss, $data);

        return response()->json($ss);
    }
}
