<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Loker;

class LokerController extends Controller
{
    public function list(Request $request)
    {
        $loker = Loker::with('uploader')
                      ->orderBy('created_at', 'desc')
                      ->get();

        dd($loker->toArray());
    }

    public function detail($id)
    {
        
    }
}
