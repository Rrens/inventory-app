<?php

namespace App\Http\Controllers\Pengelolaan;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Http\Request;

class BarangKeluarController extends Controller
{
    public function index()
    {
        $active = 'barang-keluar';
        $active_group = 'pengelolaan';

        $products = Barang::all();
        return view('website.pages.admin.pengelolaan.barang-keluar', compact('active', 'active_group', 'products'));
    }
}
