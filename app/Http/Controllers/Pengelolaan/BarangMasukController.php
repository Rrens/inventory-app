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

        $data_detail = PemesananDetail::where('status', null)
            ->whereHas('pemesanan', function ($query) {
                $query->where('is_verify', true);
            })
            ->get();

        return view('website.pages.admin.pengelolaan.barang-masuk', compact(
            'active',
            'active_group',
            'data_detail'
        ));
    }

    public function barang_masuk_selesai(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:barangs,id|exists:pemesanan_details,barang_id',
            'pemesanan_id' => 'required|exists:pemesanans,id',
            'place' => 'required|in:toko,gudang',
        ]);

        if ($validator->fails()) {
            Alert::toast($validator->messages()->all(), 'error');
            return back();
        }

        $data = Pemesanan::find($request->pemesanan_id);

        PemesananDetail::where('pemesanan_id', $data->id)->where('barang_id', (int) $request->id)->update(['status' => true, 'date_in' => now()]);

        $data_detail = PemesananDetail::where('pemesanan_id', $data->id)->get();

        foreach ($data_detail as $item) {
            $barang = Barang::where('id', $item->barang_id)
                ->where('place', $request->place)
                ->first();
            if (!empty($barang)) {
                $barang->quantity += $item->quantity;
                $barang->save();
            } else {
                $barang_other_place = Barang::where('name', Barang::find($request->id)->name)->first();
                $barang_new = new Barang();
                $barang_new->quantity = $item->quantity;
                // dd($barang_other_place->saving_cost, $barang_new);
                $barang_new->name = $barang_other_place->name;
                $barang_new->saving_cost = $barang_other_place->saving_cost;
                $barang_new->price = $barang_other_place->price;
                $barang_new->eoq = $barang_other_place->eoq;
                $barang_new->unit = $barang_other_place->unit;
                $barang_new->place = $request->place;
                $barang_new->save();
            }
        }

        Alert::toast('Barang Masuk Selesai disimpan', 'success');
        return back();
    }
}
