<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class SupplierController extends Controller
{
    public function index()
    {
        $active = 'supplier';
        $active_group = 'master';

        $id_supplier = Supplier::count() + 1;
        $data = Supplier::all();
        $name_supplier = Supplier::pluck('name');
        // dd(json_encode($name_supplier));

        return view('website.pages.admin.master.supplier', compact('active', 'active_group', 'id_supplier', 'data', 'name_supplier'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|unique:suppliers,id',
            'name' => 'required',
            'telp' => 'required',
            'description' => 'required'
        ]);

        if ($validator->fails()) {
            Alert::toast($validator->messages()->all(), 'error');
            return back()->withInput();
        }

        unset($request['_token']);
        $data = new Supplier();
        $data->fill($request->all());
        $data->save();

        Alert::toast('Sukses Menyimpan', 'success');
        return back();
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:suppliers,id',
            'name' => 'required',
            'telp' => 'required',
            'description' => 'required'
        ]);

        if ($validator->fails()) {
            Alert::toast($validator->messages()->all(), 'error');
            return back()->withInput();
        }

        unset($request['_token']);
        $data = Supplier::findOrFail($request->id);
        $data->update($request->all());

        Alert::toast('Sukses Mengubah', 'success');
        return back();
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:suppliers,id',
        ]);

        if ($validator->fails()) {
            Alert::toast($validator->messages()->all(), 'error');
            return back()->withInput();
        }

        Supplier::where('id', $request->id)->delete();

        Alert::toast('Sukses Menghapus', 'success');
        return back();
    }
}
