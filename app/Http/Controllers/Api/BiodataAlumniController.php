<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Alumni;
use App\BiodataAlumni;
use App\TracingAlumni;
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
            'alamat' => 'required|string',
            'umur' => 'required|integer',
            'ttl' => 'required|string',
            'jenis_kelamin' => 'required|string',
            'angkatan' => 'required|string',
            'jurusan' => 'required|string',
            'linkedin' => 'url',
            'foto' => 'image|max:2048'
        ]);

        if ($validator->fails()) {
            $msg = $this->mergeErrorMsg($validator->errors()->toArray());
            return response()->json([
                'success' => false,
                'message' => $msg,
                'data' => []
            ], 400);
        }        

        $url;
        if ($request->hasFile('foto')) {
            $url = Storage::put('/',$request->foto);            
        }
        
        $biodata = BiodataAlumni::create([
            'alumni_id' => $user->id,
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'umur' => $request->umur,
            'ttl' => $request->ttl,
            'jenis_kelamin' => $request->jenis_kelamin,
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

    public function createBioAndTracing(Request $request)
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
            'alamat' => 'required|string',
            'umur' => 'required|integer',
            'ttl' => 'required|string',
            'jenis_kelamin' => 'required|string',
            'angkatan' => 'required|string',
            'jurusan' => 'required|string',
            'linkedin' => 'url',
            'foto' => 'image|max:2048',
            'perusahaan' => 'required|string',
            'tahun_masuk' => 'required|string',
            'cluster' => 'required|string',
            'jabatan' => 'required|string'
        ]);

        if ($validator->fails()) {
            $msg = $this->mergeErrorMsg($validator->errors()->toArray());
            return response()->json([
                'success' => false,
                'message' => $msg,
                'data' => []
            ], 400);
        }        

        $url = null;
        if ($request->hasFile('foto')) {
            $url = Storage::put('/',$request->foto);            
        }
        
        $biodata = BiodataAlumni::create([
            'alumni_id' => $user->id,
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'umur' => $request->umur,
            'ttl' => $request->ttl,
            'jenis_kelamin' => $request->jenis_kelamin,
            'angkatan' => $request->angkatan,
            'jurusan' => $request->jurusan,
            'linkedin' => $request->linkedin,
            'foto' => $url ? url('/api/pic?pic_url=').$url : null
        ]);

        if ($biodata) {

            $tracing = TracingAlumni::create([
                'perusahaan' => $request->perusahaan,
                'tahun_masuk' => $request->tahun_masuk,
                'cluster' => $request->cluster,
                'jabatan' => $request->jabatan,
                'alumni_id' => $user->id
            ]);

            if ($tracing) {
                return response()->json([
                    'success' => true,
                    'message' => 'Biodata dan Pekerjaan anda berhasil ditambahkan.',
                    'data' => $biodata
                ]);
            }


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
            $msg = $this->validator->errors()->toArray();
            return response()->json([
                'success' => false,
                'message' => $msg,
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

    /**
     * For combine error message generated
     * from validator->errors()
     */
    private function mergeErrorMsg($msg) {
        $result = [];
        foreach ($msg as $err) {            
            foreach ($err as $e) {
                array_push($result, $e);
            }
        }
        return implode('\n', $result);
    }
}
