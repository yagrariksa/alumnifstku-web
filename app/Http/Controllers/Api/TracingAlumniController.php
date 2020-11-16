<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Alumni;
use App\BiodataAlumni;
use App\TracingAlumni;

class TracingAlumniController extends Controller
{
    public function list(Request $request)
    {
        $alumni = Alumni::with([
            'tracing' => function($query) {
                $query->orderBy('created_at', 'desc');
            }, 
            'biodata'
        ]);
        
        // filter function
        if ($request->filter) {
            $alumni->whereHas('biodata', function($query) use($request) {
                if ($request->nama) {
                    $query->where('nama', 'like', '%'.$request->nama.'%');
                }
                if ($request->angkatan) {
                    $query->where('angkatan', 'like', '%'.$request->angkatan.'%');
                }
                if ($request->jurusan) {
                    $query->where('jurusan', 'like', '%'.$request->jurusan.'%');
                }
            });
            
            if ($request->perusahaan) {
                $alumni->whereHas('tracing', function($query) use($request) {
                    $query->where('perusahaan', 'like', '%'.$request->perusahaan.'%');
                });
            }
        }        
        
        $alumni = $alumni->orderBy('created_at', 'desc')->get();        

        return response()->json([
            'success' => true,
            'message' => 'Permintaan berhasil.',
            'data' => $alumni
        ], 200);

    }

    public function detail($id)
    {
        $alumni = Alumni::find($id);

        if (!$alumni) {
            return response()->json([
                'success' => false,
                'message' => 'ID tidak ditemukan!',
                'data' => []
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Permintaan berhasil.',
            'data' => $alumni->load([
                'tracing' => function($query) {
                    $query->orderBy('created_at', 'desc');
                }, 
                'biodata'
            ]),
        ], 200);
    }
}
