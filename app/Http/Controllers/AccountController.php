<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Alumni;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Str;

class AccountController extends Controller
{
    public function verifyAlumni($token)
    {
        dd(Carbon::now());
        $alumni = Alumni::where('token_registration', $token)->first();
        
        
        if ($alumni) {
            // change registration token
            $alumni->registration_token = Str::random(50);        
            $alumni->verified_at = Carbon::now();
            $alumni->save();
            return view('email.successverified');
        }
        abort(404);
    }

    public function verifyAdmin($token)
    {
        
    }
}
