<?php

namespace App\Http\Controllers\Persetujuan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PemakaianController extends Controller
{
    public function index()
    {
        $active = 'pemakaian';
        $active_group = 'persetujuan';

        return view('website.pages.owner.persetujuan.pemakaian', compact('active', 'active_group'));
    }
}
