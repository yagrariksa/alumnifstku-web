<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Alumni;
use App\SharingAlumni;
use App\KomentarSharingAlumni;
use Storage;
use Validator;
use Intervention\Image\Facades\Image as Image;

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

    public function postMemory(Request $request)
    {        
        
        $validator = Validator::make($request->all(), [
            'foto' => 'image:jpg,jpeg,png,webp|max:5000|mimes:jpg,png,jpeg,webp',
            'deskripsi' => 'string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
                'data' => []
            ], 400);
        }
                

        if ($request->hasFile('foto')) {                        
            $url = Storage::put('/',$request->foto);            
            $sharing = SharingAlumni::create([
                'foto' => url('/api/pic?pic_url=').$url,
                'deskripsi' => $request->deskripsi,
                'alumni_id' => auth()->user()->id,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Post anda berhasil diupload.',
                'data' => $sharing
            ], 201);
        }

        return response()->json([
            'success' => false,
            'message' => 'Anda belum menambahkan foto.',
            'data' => []
        ], 400);
    }

    public function detail($id)
    {        
        $post = SharingAlumni::find($id);        
        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'ID tidak ditemukan.',
                'data' => []
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Permintaan anda berhasil.',
            'data' => $post
        ]);
    }
}
