<?php

namespace App\Http\Controllers\Pengelolaan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BarangMasukController extends Controller
{
    public function index()
    {
        $active = 'barang-masuk';
        $active_group = 'pengelolaan';

        return view('website.pages.admin.pengelolaan.barang-masuk', compact('active', 'active_group'));
    }
}
