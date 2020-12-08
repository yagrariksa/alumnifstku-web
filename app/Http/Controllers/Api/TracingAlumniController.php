<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Alumni;
use App\BiodataAlumni;
use App\TracingAlumni;
use Validator;

class TracingAlumniController extends Controller
{

    // TODO : create function for store, update, and delete tracing.
    public function create(Request $request)
    {
        $user = auth()->user();

        $validator = Validator::make($request->all(), [
            'perusahaan' => 'required|string',
            'cluster' => 'required|string',
            'tahun_masuk' => 'required|string',
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

        $tracing = TracingAlumni::create([
            'perusahaan' => $request->perusahaan,
            'cluster' => $request->cluster,
            'tahun_masuk' => $request->tahun_masuk,
            'jabatan' => $request->jabatan,
            'alumni_id' => $user->id
        ]);

        if ($tracing) {
            return response()->json([
                'success' => true,
                'message' => 'Pekerjaan anda berhasil diperbarui.',
                'data' => $user->load(['biodata', 'tracing' => function($query) {
                    $query->orderBy('created_at', 'desc');
                }])
            ], 201);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Gagal.',
                'data' => []
            ], 400);
        }
    }

    public function update(Request $request, $id)
    {
        $tracing = TracingAlumni::find($id);
        if (!$tracing) {
            return response()->json([
                'success' => false,
                'message' => 'ID tidak ditemukan.',
                'data' => []
            ], 404);
        }

        $user = auth()->user();

        $validator = Validator::make($request->all(), [
            'perusahaan' => 'required|string',
            'cluster' => 'required|string',
            'tahun_masuk' => 'required|string',
            'jabatan' => 'required|string',
        ]);

        if ($validator->fails()) {
            $msg = $this->mergeErrorMsg($validator->errors()->toArray());
            return response()->json([
                'success' => false,
                'message' => $msg,
                'data' => []
            ], 404);
        }

        $tracing->update([
            'perusahaan' => $request->perusahaan, 
            'cluster' => $request->cluster,
            'tahun_masuk' => $request->tahun_masuk,
            'jabatan' => $request->jabatan
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Informasi pekerjaan berhasil diperbarui',
            'data' => $user->load(['biodata', 'tracing' => function($query) {
                $query->orderBy('created_at', 'desc');
            }])
        ], 200);
    }

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
                // filter by name
                if ($request->nama) {
                    $query->where('nama', 'like', '%'.$request->nama.'%');
                }
                // filter by angkatan
                if ($request->angkatan) {
                    $query->where('angkatan', 'like', '%'.$request->angkatan.'%');
                }
                // filter by major
                if ($request->jurusan) {
                    $query->where('jurusan', 'like', '%'.$request->jurusan.'%');
                }
            });
            
            // filter by company
            if ($request->perusahaan) {
                $alumni->whereHas('tracing', function($query) use($request) {
                    $query->where('perusahaan', 'like', '%'.$request->perusahaan.'%');
                });
            }
            // filter by job cluster
            if ($request->cluster) {
                $alumni->whereHas('tracing', function($query) use($request) {
                    $query->where('cluster', 'like', '%'.$request->cluster.'%');
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

    public function remove($id)
    {
        $tracing = TracingAlumni::find($id);
        if (!$tracing) {
            return response()->json([
                'success' => false,
                'message' => 'ID tidak ditemukan.',
                'data' => []
            ], 404);
        }

        $user = auth()->user();

        $tracing->delete();
        return response()->json([
            'success' => true,
            'message' => 'Data pekerjaan anda berhasil dihapus.',
            'data' => $user->load([
                'tracing' => function($query) {
                    $query->orderBy('created_at', 'desc');
                },
                'biodata'
            ])
        ]);

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
