<?php

namespace App\Http\Controllers\Pengelolaan;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\CartPenjualan;
use App\Models\Notification;
use App\Models\Pemakaian;
use App\Models\Penjualan;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class PenjualanController extends Controller
{
    public function index()
    {
        $active = 'penjulan-pengelolaan';
        $active_group = 'pengelolaan';

        $products = Barang::groupBy('name')->get();
        $cart = CartPenjualan::all();

        return view('website.pages.admin.pengelolaan.penjualan', compact(
            'active',
            'active_group',
            'products',
            'cart'
        ));
    }

    public function store_cart(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'barang_id' => 'required|exists:barangs,id',
            'quantity' => 'required|numeric',
            'status' => 'required|in:true,false'
        ], [
            'barang_id.required' => 'Barang harus diisi',
            'quantity.required' => 'Quantity harus diisi',
            'quantity.numeric' => 'Quantity harus berisi nomor',
            'status.required' => 'Status harus ada',
            'status.in' => 'Status harus antara true atau false',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages()->all(), 404);
        }

        try {
            unset($request['_token']);

            $check_cart = CartPenjualan::where('barang_id', $request->barang_id)->first();
            if (!$check_cart) {
                $data = new CartPenjualan();
                $data->fill($request->all());
                if ($request->status == "false") {
                    $data->status = false;
                } else {
                    $data->status = true;
                }
                $data->save();
            } else {
                $check_cart->quantity += $request->quantity;
                $check_cart->save();
            }

            return response()->json('sukses');
        } catch (Exception $error) {
            return response()->json($error->getMessage());
        }
    }

    public function update_cart(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'barang_id' => 'required|exists:barangs,id',
            'quantity' => 'required|numeric',
            'status' => 'required|in:true,false'
        ], [
            'barang_id.required' => 'Barang harus diisi',
            'quantity.required' => 'Quantity harus diisi',
            'quantity.numeric' => 'Quantity harus berisi nomor',
            'status.required' => 'Status harus ada',
            'status.in' => 'Status harus antara true atau false',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages()->all(), 404);
        }

        try {
            unset($request['_token']);

            $data = CartPenjualan::where('barang_id', $request->id)->first();
            $data->quantity = $request->quantity;
            $data->save();

            return response()->json('sukses');
        } catch (Exception $error) {
            return response()->json($error->getMessage());
        }
    }

    public function delete_cart(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:cart_penjualans,id',
        ], [
            'id.required' => 'Cart tidak ada',
        ]);

        if ($validator->fails()) {
            Alert::toast($validator->messages()->all(), 'error');
            return back();
        }

        CartPenjualan::where('id', $request->id)->delete();

        Alert::toast('Sukses Menghapus cart', 'success');
        return back();
    }

    public function store()
    {
        $cart = CartPenjualan::all();
        foreach ($cart as $item) {
            if ($item->status == false) {
                $data = new Penjualan();
                $data->penjualan_id = Penjualan::generateID();
                $data->slug = Penjualan::generateSLUG();
                $data->barang_id = $item->barang_id;
                $data->quantity = $item->quantity;
                $data->order_date = Carbon::now();
                $data->status = false;
                $data->save();

                $barang = Barang::findOrFail($item->barang_id);
                $barang->quantity -= $item->quantity;
                $barang->save();
            } else {
                // dd($item->status == true);
                $data = new Penjualan();
                $data->penjualan_id = Penjualan::generateID();
                $data->slug = Penjualan::generateSLUG();
                $data->barang_id = $item->barang_id;
                $data->quantity = $item->quantity;
                $data->order_date = Carbon::now();
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
        }

        CartPenjualan::truncate();

        Alert::toast('Berhasil Menyimpan Pesanan', 'success');
        return back();
    }

    public function checkStock($id)
    {
        $data = Barang::where('id', $id)
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
            $data = DB::table('penjualans as p')
                ->join('barangs as b', 'p.barang_id', '=', 'b.id')
                ->selectRaw('max(p.quantity) as max, round(avg(p.quantity)) as avg, sum(p.quantity) as total, b.leadtime')
                ->whereRaw("b.id = '" . $productID . "' AND DATE_FORMAT(p.order_date, '%m-%Y') = '" . $bulan_tahun->bulan . "'")
                ->first();
        } else {
            $data = DB::table('penjualans as p')
                ->join('barangs as b', 'p.barang_id', '=', 'b.id')
                ->selectRaw('max(p.quantity) as max, round(avg(p.quantity)) as avg, sum(p.quantity) as total, b.leadtime')
                ->first();
        }


        $lead_time = !empty($data->leadtime) ? $data->leadtime : 5;
        $ss = ($data->max - $data->avg) * $lead_time;

        return response()->json($ss);
    }
}
