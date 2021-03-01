<?php

namespace App\Http\Controllers;

use App\Alumni;
use App\FstNews;
use App\KelasAlumni;
use App\Loker;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $a = Alumni::count();
        $l = Loker::count();
        $b = FstNews::count();
        $k = KelasAlumni::count();
        return view('dashboard.home',[
            'a' => $a,
            'l' => $l,
            'b' => $b,
            'k' => $k,
        ]);
    }
}
