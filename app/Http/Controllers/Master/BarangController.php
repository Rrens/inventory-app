<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Supplier;
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
        $supplier = Supplier::all();
        return view('website.pages.admin.master.barang', compact('active', 'active_group', 'data', 'id_barang', 'supplier'));
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
            'supplier_id' => 'required'
        ], [
            'name.required' => 'Gagal menyimpan data barang',
            'price.required' => 'Gagal menyimpan data barang',
            'price.numeric' => 'Harga harus berisi nomor',
            'leadtime.required' => 'Gagal menyimpan data barang',
            'leadtime.numeric' => 'Leadtime harus berisi nomor',
            'unit.required' => 'Gagal menyimpan data barang',
            'unit:in' => 'Unit hanya bisa unit, pcs, pack, zak, m3',
            'place.required' => 'Gagal menyimpan data barang',
            'place:in' => 'Place hanya bisa gudang, toko',
        ]);

        // JIKA GAGAL MAKA MUNCUL ALERT
        if ($validator->fails()) {
            Alert::toast($validator->messages()->all(), 'error');
            dd($request->all());
            return back()->withInput();
        }

        // dd($this->convert_name($request->name));

        $check_place = Barang::where('place', $request->place)
            ->where('name', $request->name)
            ->pluck('place');
        if (!empty($check_place[0])) {
            $value = $request->place == 'toko' ? 'gudang' : 'toko';
            Alert::toast("Barang Already in {$value}", 'error');
            return back()->withInput();
        }

        $data_check_name = Barang::pluck('name');

        foreach ($data_check_name as $item) {
            if ($this->convert_name($item) == $this->convert_name($request->name)) {
                Alert::toast('Data Barang sudah tersedia', 'error');
                return back()->withInput();
            }
        }
        // dd($data_check_name);

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
        $validator = Validator::make(
            $request->all(),
            [
                'id_barang' => 'required|exists:barangs,id',
                'saving_cost' => 'required|numeric',
                'name' => 'required',
                'price' => 'required|numeric',
                'leadtime' => 'required|numeric',
                'unit' => 'required|in:unit,pcs,pack,zak,m3',
                'place' => 'required|in:gudang,toko',
            ],
            [
                'name.required' => 'Gagal ubah data barang',
                'price.required' => 'Gagal ubah data barang',
                'price.numeric' => 'Harga harus berisi nomor',
                'leadtime.required' => 'Gagal ubah data barang',
                'leadtime.numeric' => 'Leadtime harus berisi nomor',
                'unit.required' => 'Gagal ubah data barang',
                'unit:in' => 'Unit hanya bisa unit, pcs, pack, zak, m3',
                'place.required' => 'Gagal ubah data barang',
                'place:in' => 'Place hanya bisa gudang, toko',
            ]
        );

        // JIKA GAGAL MAKA MUNCUL ALERT
        if ($validator->fails()) {
            Alert::toast($validator->messages()->all(), 'error');
            // dd($validator->messages());
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

    public function convert_name($data)
    {
        return str_replace(' ', '', strtolower($data));
    }
}
