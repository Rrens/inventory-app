<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        $active = 'supplier';
        $active_group = 'master';

        return view('website.pages.admin.master.supplier', compact('active', 'active_group'));
    }
}
