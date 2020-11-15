<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Alumni;
use App\User;
use Carbon\Carbon;

class AccountController extends Controller
{
    public function verifyAlumni($token)
    {
        $alumni = Alumni::where('token_registration', $token)->first();

        if ($alumni) {
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
