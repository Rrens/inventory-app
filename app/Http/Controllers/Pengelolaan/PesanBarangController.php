<?php

namespace App\Http\Controllers\Pengelolaan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PesanBarangController extends Controller
{
    public function index()
    {
        $active = 'pesan-barang';
        $active_group = 'pengelolaan';

        return view('website.pages.admin.pengelolaan.pesan-barang', compact('active', 'active_group'));
    }
}
