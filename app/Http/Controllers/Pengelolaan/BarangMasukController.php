<?php

namespace App\Http\Controllers\Pengelolaan;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Pemesanan;
use App\Models\PemesananDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class BarangMasukController extends Controller
{
    public function index()
    {
        $active = 'barang-masuk-pengelolaan';
        $active_group = 'pengelolaan';

        $data = Pemesanan::all();
        // dd($data);
        $data_detail = PemesananDetail::all();

        return view('website.pages.admin.pengelolaan.barang-masuk', compact(
            'active',
            'active_group',
            'data',
            'data_detail'
        ));
    }

    public function barang_masuk_selesai(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:pemesanans,id'
        ]);

        if ($validator->fails()) {
            Alert::toast($validator->messages()->all(), 'error');
            return back();
        }

        $data = Pemesanan::find($request->id);
        $data->status = true;
        $data->save();

        $barang = Barang::where('id', $data->barang_id)->first();
        $barang->quantity += $data->quantity;
        $barang->save();

        Alert::toast('Barang Masuk Selesai disimpan', 'success');
        return back();
    }
}
