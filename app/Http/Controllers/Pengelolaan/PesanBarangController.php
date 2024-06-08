<?php

namespace App\Http\Controllers\Pengelolaan;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Cart;
use App\Models\Pemesanan;
use App\Models\PemesananDetail;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class PesanBarangController extends Controller
{
    public function index()
    {
        $active = 'pesan-barang';
        $active_group = 'pengelolaan';

        $products = Barang::all();
        $suppliers = Supplier::all();

        $cart = Cart::all();

        return view('website.pages.admin.pengelolaan.pesan-barang', compact('active', 'active_group', 'products', 'suppliers', 'cart'));
    }

    public function store_cart(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'barang_id' => 'required|exists:barangs,id',
            'quantity' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            Alert::toast($validator->messages()->all(), 'error');
            return back()->withInput();
        }

        unset($request['_token']);
        $check_cart =
            Cart::where('barang_id', $request->barang_id)->first();

        $check_stock = Barang::where('id', $request->barang_id)->first();

        if (!empty($check_cart) && $check_cart->quantity > $check_stock->quantity) {
            Alert::toast('Kuantiti Melebihi Stok!', 'error');
            return back()->withInput();
        }

        if (!$check_cart) {
            $data = new Cart();
            $data->fill($request->all());
            $data->save();
            Alert::toast('Barang tersimpan di keranjang', 'success');
        } else {
            $check_cart->quantity += $request->quantity;
            $check_cart->save();
            Alert::toast('Barang terupdate di keranjang', 'success');
        }

        return back();
    }

    public function update_cart(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'barang_id' => 'required|exists:barangs,id',
            'quantity' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            Alert::toast($validator->messages()->all(), 'error');
            return back()->withInput();
        }

        unset($request['_token']);

        $data = Cart::where('barang_id', $request->barang_id)->first();
        $data->fill($request->all());
        $data->save();

        Alert::toast('Barang terupdate di keranjang', 'success');
        return back();
    }

    public function delete_cart(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:carts,id',
        ]);

        if ($validator->fails()) {
            Alert::toast($validator->messages()->all(), 'error');
            return back()->withInput();
        }

        Cart::where('id', $request->id)->delete();

        Alert::toast('Barang Berhasil terhapus', 'success');
        return back();
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'supplier_id' => 'required|exists:suppliers,id',
            'store_for' => 'required|in:gudang,toko',
            'order_cost' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            Alert::toast($validator->messages()->all(), 'error');
            return back()->withInput();
        }

        $pemesanan_ID = Pemesanan::generateID();

        unset($request['_token']);
        $data = new Pemesanan();
        $data->pemesanan_id = $pemesanan_ID;
        $data->slug = generate_slug('PEM');
        $data->supplier_id = $request->supplier_id;
        $data->store_for = $request->store_for;
        $data->order_cost = $request->order_cost;
        // dd($data);
        $data->save();

        $cart = Cart::all();
        foreach ($cart as $item) {

            $product = Barang::findOrFail($item->barang_id);
            $eoq = $this->count_eoq_store($request->order_cost, $product->id);
            $product->eoq = $eoq;
            $product->save();

            $data_detail = new PemesananDetail();
            $data_detail->pemesanan_id = $data->id;
            $data_detail->barang_id = $item->barang_id;
            $data_detail->quantity = $item->quantity;
            $data_detail->eoq = $eoq;
            $data_detail->save();
        }

        Cart::truncate();

        Alert::toast('Pesan Barang berhasil disimpan', 'success');
        return back();
    }

    public function count_eoq_store($orderingCost, $item_id)
    {
        $bulan_tahun = DB::table('penjualans')
            ->selectRaw('DATE_FORMAT(MAX(order_date),"%m-%Y") as bulan')
            ->whereRaw('DATE_FORMAT(order_date, "%m-%Y") < DATE_FORMAT(now(), "%m-%Y")')
            ->first();

        $s = $orderingCost;

        $data = DB::table('penjualan_details as dp')
            ->join('penjualans as p', 'dp.penjualan_id', '=', 'p.penjualan_id')
            // ->join('barang_counters as bc', 'dp.barang_counter_id', '=', 'bc.barang_counter_id')
            ->join('barangs as b', 'dp.barang_id', '=', 'b.id')
            ->selectRaw('max(dp.quantity) as max, round(avg(dp.quantity)) as avg, sum(dp.quantity) as total')
            ->whereRaw("b.id = '" . $item_id . "' AND DATE_FORMAT(p.order_date, '%m-%Y') = '" . $bulan_tahun->bulan . "'")->first();
        $barang = DB::table('barangs')->where('id', $item_id)->first();
        $h = $barang->saving_cost;
        $eoq = $data->total > 0 ? round(sqrt((2 * $data->total * $s) / $h)) : 0;

        return $eoq;
    }

    public function count_eoq(Request $request)
    {
        $bulan_tahun = DB::table('penjualans')
            ->selectRaw('DATE_FORMAT(MAX(order_date),"%m-%Y") as bulan')
            ->whereRaw('DATE_FORMAT(order_date, "%m-%Y") < DATE_FORMAT(now(), "%m-%Y")')
            ->first();
        $hasil_hitung = [];
        $pemesanans = $request['data'];
        $s = $request['data'][0]['orderingCost'];
        $no = 1;

        foreach ($pemesanans as $pemesanan) {
            $data = DB::table('penjualan_details as dp')
                ->join('penjualans as p', 'dp.penjualan_id', '=', 'p.penjualan_id')
                // ->join('barang_counters as bc', 'dp.barang_counter_id', '=', 'bc.barang_counter_id')
                ->join('barangs as b', 'dp.barang_id', '=', 'b.id')
                ->selectRaw('max(dp.quantity) as max, round(avg(dp.quantity)) as avg, sum(dp.quantity) as total')
                ->whereRaw("b.id = '" . $pemesanan['itemId'] . "' AND DATE_FORMAT(p.order_date, '%m-%Y') = '" . $bulan_tahun->bulan . "'")->first();
            $barang = DB::table('barangs')->where('id', $pemesanan['itemId'])->first();

            $h = $barang->saving_cost;
            $eoq = $data->total > 0 ? round(sqrt((2 * $data->total * $s) / $h)) : 0;
            $hasil_eoq = [
                'no' => $no++,
                'id_barang' => $pemesanan['itemId'],
                'eoq' => $eoq,
                'jumlah' => 0,
                'rowIndex' => $pemesanan['rowIndex'],
            ];

            array_push($hasil_hitung, $hasil_eoq);
        }
        return response()->json(['pemesanan' => $hasil_hitung], 200);
    }

    public function checkStock($id_barang)
    {
        $data = Barang::where('id', $id_barang)->pluck('quantity');
        return response()->json($data);
    }

    // public function count_eoq($quantity, $order_cost, $saving_cost)
    // {
    //     $eoq = round(sqrt((2 * $quantity * $order_cost) / $saving_cost));

    //     return $eoq;
    // }
}
