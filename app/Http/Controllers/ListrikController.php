<?php

namespace App\Http\Controllers;

use App\Models\Listrik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class ListrikController extends Controller
{
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'gudang' => 'required',
            'toko' => 'required'
        ], [
            'gudang.required' => 'Gudang wajib diisi',
            'toko.required' => 'Gudang wajib diisi',
        ]);

        if ($validator->fails()) {
            Alert::toast($validator->messages()->all(), 'error');
            return back()->withInput();
        }
        // dd($request->all());

        Listrik::where('place', 'Gudang')->update(['price' => $request->gudang]);

        Listrik::where('place', 'Toko')->update(['price' => $request->toko]);

        Alert::toast('Sukses Merubah Biaya Listrik', 'success');
        return back();
    }
}
