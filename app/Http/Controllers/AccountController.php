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
        return 'TODO : Create Reset Password Page Template!';
    }
}
