<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Alumni;
use App\BiodataAlumni;
use App\SharingAlumni;
use App\KomentarSharingAlumni;
use App\Mail\SharingNotif;
use App\NotifAlumni;
use App\PostLike;
use Illuminate\Support\Facades\Mail;
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
            $msg = $this->mergeErrorMsg($validator->errors()->toArray());
            return response()->json([
                'success' => false,
                'message' => $msg,
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
            $msg = $this->mergeErrorMsg($validator->errors()->toArray());
            return response()->json([
                'success' => false,
                'message' => $msg,
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

    public function removeMemory($id)
    {
        $post = SharingAlumni::find($id);
        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'Posting tidak ditemukan.',
                'data' => []
            ], 404);
        }

        /* remove file first */
        $filename = explode('=',$post->foto)[1];            
        Storage::delete($filename);

        $post->delete();
        return response()->json([
            'success' => true,
            'message' => 'Posting anda berhasil dihapus.',
            'data' => []
        ], 200);

    }

    public function myPost()
    {
        $post = SharingAlumni::where('alumni_id', auth()->user()->id)
                             ->with(['alumni', 'tag', 'likes', 'comment'])
                             ->orderBy('created_at', 'desc')
                             ->get();
        
        return response()->json([
            'success' => true,
            'message' => 'Permintaan anda berhasil.',
            'data' => $post
        ], 200);
    }

    public function timeline()
    {
        $sharing = SharingAlumni::with(['alumni', 'tag', 'likes', 'comment', 'alumni.biodata'])
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
            'data' => $post->load([
                'alumni', 
                'tag', 
                'likes', 
                'comment' => function($query) {
                    $query->orderBy('created_at', 'desc');
                }, 
                'alumni.biodata'])
        ], 200);
    }

    public function like($id)
    {
        $post = SharingAlumni::find($id);
        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'Posting tidak ditemukan.',
                'data' => []
            ], 404);
        }
        
        $attr = PostLike::create([
            'sharing_alumni_id' => $id,
            'alumni_id' => auth()->user()->id
        ]);

        // dapetin si pemilik postingan
        $sharing = SharingAlumni::find($id);
        $penyuka = auth()->user()->biodata;
        $alumni = $sharing->alumni;
        $email = $alumni->email;

        // bikin trigger kirim email
        Mail::to($email)->send(new SharingNotif($sharing->foto, 'menyukai', $penyuka->nama));

        // bikin record data notif
        $notif = NotifAlumni::create(
            [
                'text' => $penyuka->nama . " menyukai postingan anda", 
                'is_read' => false, 
                'alumni_id' => $alumni->id, 
                'sharing_id' => $sharing->id,
            ]
        );


        return response()->json([
            'success' => true,
            'message' => 'Permintaan anda berhasil.',
            'data' => $post->load([
                'alumni', 
                'tag', 
                'likes', 
                'comment' => function($query) {
                    $query->orderBy('created_at', 'desc');
                }, 
                'alumni.biodata'
            ])
        ], 201);
    }

    public function unlike($id)
    {
        $post = SharingAlumni::find($id);
        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'Posting tidak ditemukan.',
                'data' => []
            ], 404);
        }        

        $attr = PostLike::where('sharing_alumni_id', $id)->where('alumni_id', auth()->user()->id)->first();
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
            'data' => $post->load([
                'alumni', 
                'tag', 
                'likes', 
                'comment' => function($query) {
                    $query->orderBy('created_at', 'desc');
                }, 
                'alumni.biodata'])
        ], 200);
    }

    /**
     * 
     * method untuk menampilkan
     * list komentar pada suatu
     * post
     */
    public function comments($id)
    {
        $post = SharingAlumni::with(['comment' => function($query) {
            $query->orderBy('created_at', 'desc');
        }])->find($id);

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
            'data' => $post->comment->load(['alumni', 'alumni.biodata'])
        ], 200);
    }

    public function postComment(Request $request, $id)
    {
        $post = SharingAlumni::with(['comment' => function($query) {
            $query->orderBy('created_at', 'desc');
        }])->find($id);
        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'Posting tidak ditemukan.',
                'data' => []
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'text' => 'required|string|max:255',            
        ]);

        if ($validator->fails()) {
            $msg = $this->mergeErrorMsg($validator->errors()->toArray());
            return response()->json([
                'success' => false,
                'message' => $msg,
                'data' => []
            ], 400);
        }

        // dapetin si pemilik postingan
        $sharing = SharingAlumni::find($id);
        $penyuka = auth()->user()->biodata;
        $alumni = $sharing->alumni;
        $email = $alumni->email;

        // bikin trigger kirim email
        Mail::to($email)->send(new SharingNotif($sharing->foto, 'mengomentari', $penyuka->nama));

        // bikin record data notif
        $notif = NotifAlumni::create(
            [
                'text' => $penyuka->nama . " mengomentari postingan anda", 
                'is_read' => false, 
                'alumni_id' => auth()->user()->id, 
                'sharing_id' => $sharing->id,
            ]
        );

        $comment = KomentarSharingAlumni::create([
            'alumni_id' => auth()->user()->id,
            'sharing_alumni_id' => $post->id,
            'text' => $request->text
        ]);

        if ($comment) {
            return response()->json([
                'success' => true,
                'message' => 'Komentar anda berhasil ditambahkan.',
                'data' => $post->comment->load(['alumni', 'alumni.biodata'])
            ], 201);
        }

        return response()->json([
            'success' => false,
            'message' => 'Komentar anda gagal ditambahkan.',
            'data' => []
        ], 400);
    }

    public function removeComment($id, $commentId)
    {
        $post = SharingAlumni::with(['comment' => function($query) {
            $query->orderBy('created_at', 'desc');
        }])->find($id);
        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'Posting tidak ditemukan.',
                'data' => []
            ], 404);
        }

        $comment = KomentarSharingAlumni::find($commentId);
        if (!$comment) {
            return response()->json([
                'success' => false,
                'message' => 'Komentar tidak ditemukan.',
                'data' => []
            ], 404);
        }

        if ($comment->alumni_id == auth()->user()->id || $post->alumni_id == auth()->user()->id) {
            $comment->delete();
            return response()->json([
                'success' => true,
                'message' => 'Komentar berhasil dihapus.',
                'data' => $post->comment->load(['alumni', 'alumni.biodata'])
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Anda tidak berhak melakukan operasi ini.',
            'data' => []
        ], 403);

    }

    /**
     * For combine error message generated
     * from validator->errors()
     */
    private function mergeErrorMsg($msg)
    {
        $result = [];
        foreach ($msg as $err) {            
            foreach ($err as $e) {
                array_push($result, $e);
            }
        }
        return implode('\n', $result);
    }

    public function notif()
    {
        $notif = NotifAlumni::where('alumni_id', auth()->user()->id)
                            ->with('alumni', 'post')
                            ->orderBy('created_at', 'desc')
                            ->get();

        $hey = NotifAlumni::where('alumni_id', auth()->user()->id)
                        ->where('is_read', false)
                        ->get();

        foreach($hey as $h)
        {
            $h->is_read = true;
            $h->save();
        }
                            
        return response()->json([
            'success' => true,
            'message' => 'Permintaan anda berhasil.',
            'data' => $notif
        ], 200);                        
    }
}
