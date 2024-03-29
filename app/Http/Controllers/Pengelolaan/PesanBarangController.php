<?php

namespace App\Http\Controllers\Pengelolaan;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Http\Request;

class PesanBarangController extends Controller
{
    public function index()
    {
        $active = 'pesan-barang';
        $active_group = 'pengelolaan';

        $products = Barang::all();

        return view('website.pages.admin.pengelolaan.pesan-barang', compact('active', 'active_group', 'products'));
    }
}
