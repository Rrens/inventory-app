<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class BarangController extends Controller
{
    public function index()
    {
        // MENAMPILKAN BARANG
        $active_group = 'master';
        $active = 'barang';
        $data = Barang::all();
        $id_barang = Barang::count() + 1;
        return view('website.pages.admin.master.barang', compact('active', 'active_group', 'data', 'id_barang'));
    }

    public function store(Request $request)
    {
        // VALIDASI INPUT REQUEST
        $validator = Validator::make($request->all(), [
            'id_barang' => 'required|unique:barangs,id',
            'saving_cost' => 'required|numeric',
            'name' => 'required',
            'price' => 'required|numeric',
            'leadtime' => 'required|numeric',
            'unit' => 'required|in:unit,pcs,pack,zak,m3',
            'place' => 'required|in:gudang,toko',
        ]);

        // JIKA GAGAL MAKA MUNCUL ALERT
        if ($validator->fails()) {
            Alert::toast($validator->messages()->all(), 'error');
            return back()->withInput();
        }

        $check_place = Barang::where('place', $request->place)
            ->where('name', $request->name)
            ->pluck('place');
        if (empty($check_place[0])) {
            $value = $request->place == 'toko' ? 'gudang' : 'toko';
            Alert::toast("Barang Already in {$value}", 'error');
            return back()->withInput();
        }

        // MENYIMPAN BARANG BARU
        unset($request['_token']);
        $data = new Barang();
        $data->fill($request->all());
        $data->save();

        Alert::toast('Sukses Menyimpan', 'success');
        return back();
    }

    public function update(Request $request)
    {
        // VALIDASI INPUT REQUEST
        $validator = Validator::make($request->all(), [
            'id_barang' => 'required|exists:barangs,id',
            'saving_cost' => 'required|numeric',
            'name' => 'required',
            'price' => 'required|numeric',
            'leadtime' => 'required|numeric',
            'unit' => 'required|in:unit,pcs,pack,zak,m3',
            'place' => 'required|in:gudang,toko',
        ]);

        // JIKA GAGAL MAKA MUNCUL ALERT
        if ($validator->fails()) {
            Alert::toast($validator->messages()->all(), 'error');
            return back()->withInput();
        }

        unset($request['_token']);
        // MENCARI BARANG DENGAN ID SESUAI REQUEST
        $data = Barang::findOrFail($request->id_barang);
        $data->fill($request->all());
        $data->update();

        Alert::toast('Sukses Mengubah', 'success');
        return back();
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_barang' => 'required|exists:barangs,id'
        ]);

        if ($validator->fails()) {
            Alert::toast($validator->messages()->all(), 'error');
            return back()->withInput();
        }

        // MENCARI BARANG DENGAN ID SESUAI REQUEST LALU DIHAPUS
        Barang::where('id', $request->id_barang)->delete();
        Alert::toast('Sukses Menghapus', 'success');
        return back();
    }
}
