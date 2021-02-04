<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Alumni;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AccountController extends Controller
{
    public function verifyAlumni($token)
    {
        $alumni = Alumni::where('token_registration', $token)->first();

        if ($alumni) {
            if ($alumni->verified_at) {
                return view('email.successverified');
            }
            // change registration token
            $alumni->token_registration = Str::random(50);
            $alumni->verified_at = Carbon::now();
            $alumni->save();
            return view('email.successverified');
        }
        abort(404);
    }

    public function verifyAdmin($token)
    {
    }

    public function resetPassword($token)
    {
        // return 'TODO : Create Reset Password Page Template!';
        $alumni = Alumni::where('token_registration', $token)->first();
        if ($alumni) {

            return view('alumni.resetpassword', [
                'token' => $token,
                'email' => $alumni->email,
            ]);
        } else {
            echo("PENGGUNA TIDAK DITEMUKAN");
        }
    }

    public function postreset(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'email' => 'required|string',
                'password' => 'min:6|required_with:password_confirmation|same:password_confirmation',
                'password_confirmation' => 'min:6'
            ]
        );

        if ($validator->fails()) {
            flash('error')->error();
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $alumni = Alumni::where('token_registration', $request->token)->first();

        if ($alumni) {
            $alumni->password = Hash::make($request->password);
            $alumni->token_registration = Str::random(50);
            // dd($alumni);
            $alumni->save();
            echo "BERHASIL";
        } else {
            echo "GAGAL";
        }
    }
}
