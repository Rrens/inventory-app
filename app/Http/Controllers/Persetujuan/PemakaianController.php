<?php

namespace App\Http\Controllers\Persetujuan;

use App\Http\Controllers\Controller;
use App\Models\Pemakaian;
use App\Models\Penjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class PemakaianController extends Controller
{
    public function index()
    {
        $active = 'pemakaian';
        $active_group = 'persetujuan';

        $data = Pemakaian::whereNull('status')->get();
        // dd($data);
        return view('website.pages.owner.persetujuan.pemakaian', compact('active', 'active_group', 'data'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:pemakaians,id',
            'status' => 'required|in:approve,decline'
        ]);

        if ($validator->fails()) {
            Alert::toast($validator->messages()->all(), 'error');
            return back()->withInput();
        }

        $data = Pemakaian::findOrFail($request->id);
        if ($request->status == 'approve') {
            $data->status = true;

            $penjualan = Penjualan::findOrFail($data->penjualan[0]->penjualan_id);
            $penjualan->status = true;
            $penjualan->save();
        } else {
            $data->status = false;
        }
        // dd($data);
        $data->save();

        return back();
    }
}
