<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class AuthController extends Controller
{
    public function redirect()
    {
        if (Auth::user()->role == 'admin') {
            return redirect()->route('admin.dashboard.index');
        }

        return redirect()->route('owner.dashboard.index');
    }

    public function index()
    {
        if (!Auth::check()) {
            return view('auth.login');
        }

        return $this->redirect();
    }

    public function post_login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|exists:users,username',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            Alert::toast($validator->messages()->all(), 'error');
            return back()->withInput();
        }

        $data = [
            'username' => $request->username,
            'password' => $request->password
        ];

        if (!Auth::attempt($data)) {
            Alert::toast('Username atau Password Salah', 'error');
            return back()->withInput();
        }

        return $this->redirect();
    }

    public function logout()
    {
        Auth::logout();
        Alert::toast('Anda Telah Logout', 'success');
        return redirect()->route('login');
    }
}
