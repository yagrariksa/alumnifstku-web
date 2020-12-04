<?php

namespace App\Http\Controllers\Api;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Alumni;
use App\Mail\AccountVerificationMail;
use App\Mail\ForgotPasswordMail;

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
            'api_token' => hash('sha256', Str::random(80))
        ]);

        if ($alumni) {            
            Mail::to($alumni->email)->send(new AccountVerificationMail($alumni));
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
                'data' => $alumni->makeVisible(['api_token', 'username']),
            ], 201);
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
        $validator = Validator::make(
            $request->all(),
            [
                'username' => 'required_without:email|string',
                'email' => 'required_without:username|string|email',
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

        $alumni = Alumni::where('username', $request->username)
                        ->orWhere('email', $request->email)
                        ->first();

        if (!$alumni) {
            return response()->json([
                'success' => false,
                'message' => 'Username/email tidak ditemukan.',
                'data' => []
            ], 404);
        }
        if (Hash::check($request->password, $alumni->password)) {
            // if (!$alumni->verified_at) {
            //     return response()->json([
            //         'success' => false,
            //         'message' => 'Anda belum melakukan verifikasi akun. Silakan verifikasi terlebih dahulu, atau kirim ulang email verifikasi.',
            //         'data' => []
            //     ], 403);
            // }

            $alumni->api_token = hash('sha256', Str::random(80));
            $alumni->save();
            $alumni->makeVisible(['api_token', 'username', 'verified_at']);

            return response()->json([
                'success' => true,
                'message' => 'Selamat datang :)',
                'data' => $alumni,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Password tidak cocok.',
                'data' => []
            ], 403);
        }
    }

    public function hasVerified()
    {
        $alumni = Alumni::find(auth()->user()->id);

        if ($alumni->verified_at) {
            return response()->json(true);
        } else {
            return response()->json(false);
        }
    }

    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required_without:username|email',
            'username' => 'required_without:email|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->fails(),
                'data' => []
            ]);
        }

        $alumni = Alumni::where('email', $request->email)
                        ->orWhere('username', $request->username)
                        ->first();
        
        if (!$alumni) {
            return response()->json([
                'success' => false,
                'message' => 'Username/email tidak ditemukan.',
                'data' => []
            ], 404);
        }

        Mail::to($alumni->email)->send(new ForgotPasswordMail($alumni));
        if (count(Mail::failures()) > 0) {
            $alumni->delete();
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengirim email reset password',
                'data' => []
            ], 400);
        }

        return response()->json([
            'success' => true,
            'message' => 'Permintaan reset password berhasil dikirim. Cek email anda untuk mengubah password.',
            'data' => $alumni,
        ], 200);
        
    }

    public function resendVerification(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required_without:username|email',
            'username' => 'required_without:email|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->fails(),
                'data' => []
            ]);
        }

        $alumni = Alumni::where('email', $request->email)
                        ->orWhere('username', $request->username)
                        ->first();
        
        if (!$alumni) {
            return response()->json([
                'success' => false,
                'message' => 'Username/email tidak ditemukan.',
                'data' => []
            ], 404);
        }
                
        if ($alumni->verified_at) {
            return response()->json([
                'success' => true,
                'message' => 'Anda telah melakukan verifikasi akun.',
                'data' => []
            ], 200);
        }

        Mail::to($alumni->email)->send(new AccountVerificationMail($alumni));
        if (count(Mail::failures()) > 0) {
            $alumni->delete();
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengirim ulang email verifikasi akun.',
                'data' => []
            ], 400);
        }

        return response()->json([
            'success' => true,
            'message' => 'Email verifikasi akun telah dikirim ulang. Cek email anda untuk memverifikasi akun.',
            'data' => $alumni,
        ], 200);
    }

    public function changePassword(Request $request)
    {
        
    }
}
