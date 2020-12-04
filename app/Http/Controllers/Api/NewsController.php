<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\FstNews;

class NewsController extends Controller
{
    public function list(Request $request)
    {
        $news = FstNews::with('uploader');

        // filter function
        if ($request->filter) {
            // filter by title
            if ($request->judul) {
                $news->where('judul', 'like', '%'.$request->judul.'%');
            }
        }

        // order function
        $order = 'desc';     // default ordering
        if ($request->order) {
            $order = $request->order;
        }

        $news = $news->orderBy('created_at', $order)->get();

        return response()->json([
            'success' => true,
            'message' => 'Permintaan berhasil.',
            'data' => $news
        ]);
    }

    public function detail($id)
    {
        $news = FstNews::find($id);

        if (!$news) {
            return response()->json([
                'success' => false,
                'message' => 'ID tidak ditemukan!',
                'data' => []
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Permintaan berhasil.',
            'data' => $news->load('uploader')
        ], 200);
    }
}
