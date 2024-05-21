<?php

namespace App\Http\Controllers\Pengelolaan;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Cart;
use App\Models\Pemesanan;
use App\Models\PemesananDetail;
use App\Models\Supplier;
use Illuminate\Http\Request;
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
        // dd($pemesanan_ID);

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
            $data_detail = new PemesananDetail();
            $data_detail->pemesanan_id = $data->id;
            $data_detail->barang_id = $item->barang_id;
            $data_detail->quantity = $item->quantity;
            $data_detail->eoq = $item->barang[0]->eoq;
            $data_detail->save();
        }

        Cart::truncate();

        Alert::toast('Pesan Barang berhasil disimpan', 'success');
        return back();
    }
}
