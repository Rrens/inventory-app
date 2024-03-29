<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function owner()
    {
        $active = 'dashboard';
        $active_group = 'dashboard';
        return view('website.pages.owner.dashboard', compact('active', 'active_group'));
    }
}
