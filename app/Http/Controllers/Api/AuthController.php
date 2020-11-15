<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\Alumni;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Mail\AccountVerificationMail;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'username' => 'required|string|unique:alumnis',
                'email' => 'required|string|email|unique:alumnis',
                'password' => 'required|min:6'
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
                'data' => []
            ], 404);
        }

        $alumni = Alumni::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'token_registration' => Str::random(50),
            // 'api_token' => hash('256', Str::random(80));
        ]);

        if ($alumni) {            
            Mail::to($alumni->email)->send(new AccountVerificationMail(route('verify.alumni', $alumni->token_registration)));
            if (count(Mail::failures()) > 0) {
                $alumni->delete();
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal mengirim email verifikasi',
                    'data' => []
                ], 400);
            }

            return response()->json([
                'success' => true,
                'message' => 'Pendaftaran Berhasil! Cek email anda untuk verifikasi akun.',
                'data' => $alumni,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Pendaftaran Gagal!',
                'data' => []
            ], 404);
        }
    }

    public function login(Request $request)
    {
        
    }
}
