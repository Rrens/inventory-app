<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    public function index()
    {
        $active = 'user';
        $active_group = 'user';
        $data = User::all();
        $id = User::count() + 1;
        return view('website.pages.owner.user.user-management', compact('active', 'active_group', 'data', 'id'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|unique:users,id',
            'name' => 'required',
            'username' => 'required|unique:users,username',
            'password' => 'required',
            'role' => 'required|in:admin,owner'
        ]);

        if ($validator->fails()) {
            Alert::toast($validator->messages()->all(), 'error');
            return back()->withInput();
        }

        unset($request['_token']);
        $data = new User();
        $data->fill($request->all());
        $data->save();

        Alert::toast('Sukses Menyimpan', 'success');
        return back();
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:users,id',
            'name' => 'required',
            'username' => 'required|exists:users,username',
            'password' => 'nullable',
            'role' => 'required|in:admin,owner'
        ]);
        if ($validator->fails()) {
            Alert::toast($validator->messages()->all(), 'error');
            return back()->withInput();
        }

        unset($request['_token']);
        $data = User::findOrFail($request->id);
        if (!empty($request->password)) {
            $data->update($request->all());
        } else {
            unset($request['password']);
            $data->update($request->all());
        }

        Alert::toast('Sukses Mengubah', 'success');
        return back();
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            Alert::toast($validator->messages()->all(), 'error');
            return back()->withInput();
        }

        User::where('id', $request->id)->delete();

        Alert::toast('Sukses Menghapus', 'success');
        return back();
    }
}
