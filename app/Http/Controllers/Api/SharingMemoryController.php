<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Alumni;
use App\SharingAlumni;
use App\KomentarSharingAlumni;
use App\PostLike;
use Storage;
use Validator;
use Intervention\Image\Facades\Image as Image;

class SharingMemoryController extends Controller
{

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

    public function updateMemory(Request $request, $id)
    {

        $post = SharingAlumni::find($id);
        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'Post tidak ditemukan.',
                'data' => []
            ], 404);
        }        

        $validator = Validator::make($request->all(), [
            'foto' => 'image:jpg,jpeg,png,webp|max:5000|mimes:jpg,png,jpeg,webp',
            'deskripsi' => 'string|nullable'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
                'data' => []
            ], 400);
        }

        if ($request->hasFile('foto')) {                        

            /* remove old files first */
            $filename = explode('=',$post->foto)[1];            
            Storage::delete($filename);

            $url = Storage::put('/',$request->foto);            
            $post->update([
                'foto' => url('/api/pic?pic_url=').$url
            ]);
        }

        if ($request->deskripsi != $post->deskripsi) {
            $post->update([
                'deskripsi' => $request->deskripsi
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Post anda berhasil diperbarui',
            'data' => $post
        ], 200);
        
    }

    public function removeMemory(Request $request, $id)
    {
        
    }

    public function timeline(Request $request)
    {
        $sharing = SharingAlumni::with(['alumni', 'tag', 'likes', 'comment'])
                                ->orderBy('created_at', 'desc')
                                ->get();

        return response()->json([
            'success' => true,
            'message' => 'Permintaan berhasil.',
            'data' => $sharing
        ], 200);
    }    

    public function detail($id)
    {        
        $post = SharingAlumni::find($id);        
        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'Posting tidak ditemukan.',
                'data' => []
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Permintaan anda berhasil.',
            'data' => $post->load(['alumni', 'tag', 'likes', 'comment'])
        ]);
    }

    public function like(Request $request, $id)
    {        
        $validator = Validator::make($request->all(), [
            'alumni_id' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
                'data' => []
            ], 400);
        }

        $post = SharingAlumni::find($id);
        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'Posting tidak ditemukan.',
                'data' => []
            ], 404);
        }

        $alumni = Alumni::find($request->alumni_id);
        if (!$alumni) {
            return response()->json([
                'success' => false,
                'message' => 'User tidak ditemukan.',
                'data' => []
            ], 404);
        }

        $attr = PostLike::create([
            'sharing_alumni_id' => $id,
            'alumni_id' => $request->alumni_id
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Permintaan anda berhasil.',
            'data' => $post->load(['alumni', 'tag', 'likes', 'comment'])
        ], 201);
    }

    public function unlike(Request $request, $id)
    {
        $post = SharingAlumni::find($id);
        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'Posting tidak ditemukan.',
                'data' => []
            ], 404);
        }

        $alumni = Alumni::find($request->alumni_id);
        if (!$alumni) {
            return response()->json([
                'success' => false,
                'message' => 'User tidak ditemukan.',
                'data' => []
            ], 404);
        }

        $attr = PostLike::where('sharing_alumni_id', $id)->where('alumni_id', $request->alumni_id)->first();
        if (!$attr) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak dapat melakukan operasi ini.',
                'data' => []
            ], 404);
        }

        $attr->delete();
        return response()->json([
            'success' => true,
            'message' => 'Permintaan anda berhasil.',
            'data' => $post->load(['alumni', 'tag', 'likes', 'comment'])
        ], 200);
    }
}
