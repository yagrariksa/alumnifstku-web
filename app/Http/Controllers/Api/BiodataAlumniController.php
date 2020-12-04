<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Alumni;
use App\BiodataAlumni;
use Validator;
use Storage;

class BiodataAlumniController extends Controller
{
    public function create(Request $request)
    {
        $user = auth()->user();
        
        if ($user->biodata) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah mengisi biodata',
                'data' => []
            ], 400);
        }

        $validator = Validator::make($request->all(), [
            'nama' => 'required|string',
            'angkatan' => 'required|string',
            'jurusan' => 'required|string',
            'linkedin' => 'url',
            'foto' => 'image|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
                'data' => []
            ], 400);
        }        

        $url;
        if ($request->hasFile('foto')) {
            $url = Storage::put($request->foto);            
        }
        
        $biodata = BiodataAlumni::create([
            'alumni_id' => $user->id,
            'nama' => $request->nama,
            'angkatan' => $request->angkatan,
            'jurusan' => $request->jurusan,
            'linkedin' => $request->linkedin,
            'foto' => url('/api/pic?pic_url=').$url
        ]);

        if ($biodata) {
            return response()->json([
                'success' => true,
                'message' => 'Biodata anda berhasil ditambahkan.',
                'data' => $biodata
            ], 201);
        }

        return response()->json([
            'success' => false,
            'message' => 'Biodata anda gagal ditambahkan.',
            'data' => []
        ], 400);
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $biodata = BiodataAlumni::where('alumni_id', $user->id)->first();
        if (!$biodata) {
            return response()->json([
                'success' => false,
                'message' => 'Anda belum menambahkan biodata.',
                'data' => []
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'nama' => 'required|string',
            'angkatan' => 'required|string',
            'jurusan' => 'required|string',
            'linkedin' => 'url',
            'foto' => 'image|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
                'data' => []
            ], 400);
        }

        $url;
        if ($request->hasFile('foto')) {

            /* remove old files first */
            $filename = explode('=',$biodata->foto)[1];            
            Storage::delete($filename);
            
            $url = Storage::put('/',$request->foto); 
            $biodata->update([
                'foto' => url('api/pic?pic_url=').$url
            ]);
        }

        if ($request->nama != $biodata->nama) {
            $biodata->update([
                'nama' => $request->nama
            ]);
        }
        if ($request->angkatan != $biodata->angkatan) {
            $biodata->update([
                'angkatan' => $request->angkatan
            ]);
        }
        if ($request->jurusan != $biodata->jurusan) {
            $biodata->update([
                'jurusan' => $request->jurusan
            ]);
        }
        if ($request->linkedin != $biodata->linkedin) {
            $biodata->update([
                'linkedin' => $request->linkedin
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Biodata anda berhasil diperbarui',
            'data' => $biodata
        ], 200);

    }

    public function my()
    {
        $user = auth()->user();

        $biodata = BiodataAlumni::where('alumni_id', $user->id)->first();
        if (!$biodata) {
            return response()->json([
                'success' => false,
                'message' => 'Anda belum menambahkan biodata.',
                'data' => []
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Permintaan anda berhasil.',
            'data' => $biodata
        ], 200);
    }
}
