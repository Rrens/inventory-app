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

        $listrik_gudang = Listrik::where('place', 'Gudang')->first();
        $listrik_gudang->price = $request->gudang;
        $listrik_gudang->save();

        $listrik_toko = Listrik::where('place', 'Toko')->first();
        $listrik_toko->price = $request->toko;
        $listrik_gudang->save();

        Alert::toast('Sukses Merubah Biaya Listrik', 'success');
        return back();
    }
}
