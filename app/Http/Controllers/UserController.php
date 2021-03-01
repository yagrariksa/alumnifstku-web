<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Validator;
use Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function admin()
    {
        $user = Auth::user();

        if ($user->role > 1) {
            return redirect()->route('my.edit');
        }

        $users = User::all()->except($user->id);
        return view('user.index', [
            'users' => $users,
        ]);
        // return redirect()->route('my.edit');
    }

    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make('password'),
            'role' => 2,
        ]);

        $message = "Sukses Menambahkan akun " . $request->email;

        return redirect()->back()->with('success', $message);
    }

    public function log()
    {
        return redirect()->route('dashboard.index');
        $users = User::all()->except(Auth::user()->id);
        return view('user.adminlog', [
            'admins' => $users,
        ]);
    }

    public function edit()
    {
        return view('user.edit');
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required'],
            'email' => ['required', 'email'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', 'Gagal Update identitas, ada yang salah');
        }

        $user = Auth::user();

        if ($user->name != $request->name) {
            $user->update([
                'name' => $request->name,
            ]);
        }

        if ($user->email != $request->email) {
            $user->update([
                'email' => $request->email,
            ]);
        }

        $user->save();

        return redirect()->back()->with('success', 'Berhasil Update Profile');
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password_current' => 'required',
            'password' => 'required|confirmed'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', 'Password harus anda isi atau Password baru anda tidak cocok');
        }

        $user = Auth::user();

        if (!(Hash::check($request->password_current, $user->password))) {
            return redirect()->back()->with('error', 'Password anda sekarang SALAH');
        }

        if (Hash::check($request->password, $user->password)) {
            return redirect()->back()->with('error', 'Tidak bisa mengganti password dengan password yang sama sebelumnya');
        }

        $user->password = Hash::make($request->password);

        $user->save();

        return redirect()->back()->with('success', 'Berhasil Mengganti Password');
    }
}
