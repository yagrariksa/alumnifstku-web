<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Alumni;
use App\SharingAlumni;
use App\KomentarSharingAlumni;

class SharingMemoryController extends Controller
{
    public function timeline(Request $request)
    {
        $sharing = SharingAlumni::with(['alumni', 'tag', 'attribute', 'comment'])
                                ->orderBy('created_at', 'desc')
                                ->get();

        return response()->json([
            'success' => true,
            'message' => 'Permintaan berhasil.',
            'data' => $sharing
        ], 200);
    }
}
