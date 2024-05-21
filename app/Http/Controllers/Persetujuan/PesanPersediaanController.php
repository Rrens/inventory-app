<?php

namespace App\Http\Controllers\Persetujuan;

use App\Http\Controllers\Controller;
use App\Models\Pemesanan;
use App\Models\PemesananDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class PesanPersediaanController extends Controller
{
    public function index()
    {
        $active = 'pesan-persediaan';
        $active_group = 'persetujuan';

        $data = Pemesanan::all();
        return view('website.pages.owner.persetujuan.pesan-persediaan', compact('active', 'active_group', 'data'));
    }

    public function detail($slug)
    {
        $active = 'pesan-persediaan';
        $active_group = 'persetujuan';

        $data = Pemesanan::where('slug', $slug)->first();

        $data_detail = DB::table('pemesanans as p')
            ->join('pemesanan_details as pd', 'p.pemesanan_id', '=', 'p.id')
            ->join('barangs as b', 'pd.barang_id', '=', 'b.id')
            ->selectRaw('b.id, b.name, pd.quantity, p.slug, pd.eoq, b.quantity')
            ->where('p.slug', $slug)
            ->get();

        $bulan_tahun = DB::table('penjualans')
            ->selectRaw('DATE_FORMAT(MAX(order_date),"%m-%Y") as bulan')
            ->whereRaw('DATE_FORMAT(order_date, "%m-%Y") < DATE_FORMAT(now(), "%m-%Y")')
            ->first();
        dd($bulan_tahun);
        return view('website.pages.owner.persetujuan.pesan-persediaan-detail', compact('active', 'active_group', 'data'));
    }

    public function action_verif_or_not(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:pemesanans,id',
            'status' => 'required|in:decline,acc'
        ]);

        if ($validator->fails()) {
            Alert::toast($validator->messages()->all(), 'error');
            return back();
        }

        $data = Pemesanan::findOrFail($request->id);
        if ($request->status == 'decline') {
            $data->is_verify = false;
        } else {
            $data->is_verify = true;
        }
        $data->save();

        Alert::toast('Sukses Menyimpan data', 'success');
        return back();
    }
}
