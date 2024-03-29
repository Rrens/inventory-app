<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PesanPersediaanController extends Controller
{
    public function index()
    {
        $active = 'pesan-persediaan';
        $active_group = 'laporan';
        $data = null;
        return view('website.pages.owner.laporan.pesan-persediaan', compact('active', 'active_group', 'data'));
    }
}
