<?php

namespace App\Http\Controllers\Persetujuan;

use App\Http\Controllers\Controller;
use App\Models\Pemakaian;
use Illuminate\Http\Request;

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
}
