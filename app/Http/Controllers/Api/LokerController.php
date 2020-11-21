<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Loker;

class LokerController extends Controller
{
    public function list(Request $request)
    {
        $loker = Loker::with('uploader');
                    //   ->orderBy('created_at', 'desc')
                    //   ->get();

        // filter function
        if ($request->filter) {
            // filter by position
            $loker->where('jabatan', 'like', '%'.$request->jabatan.'%');

            // filter by company
            $loker->where('perusahaan', 'like', '%'.$request->perusahaan.'%');

            // filter by cluster
            $loker->where('cluster', 'like', '%'.$request->cluster.'%');
        }

        // order by
        $order = 'desc';   // default ordering
        if ($request->order) {
            $order = $request->order;
        }

        $loker = $loker->orderBy('created_at', $order)->get();

        return response()->json([
            'success' => true,
            'message' => 'Permintaan berhasil.',
            'data' => $loker
        ], 200);

    }

    public function detail($id)
    {
        $loker = Loker::find($id);

        if (!$loker) {
            return response()->json([
                'success' => false,
                'message' => 'ID tidak ditemukan!',
                'data' => []
            ], 404);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Permintaan berhasil.',
            'data' => $loker->load('uploader')
        ]);
    }
}
