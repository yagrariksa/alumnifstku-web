<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use App\BookingKelas;
use App\DataKelasAlumni;
use App\KelasAlumni;
use App\Alumni;
use App\Mail\TicketMail;
use Carbon\Carbon;
use Validator;

class KelasAlumniController extends Controller
{
    public function list(Request $request)
    {
        $kelas = KelasAlumni::with(['uploader', 'dataSpeaker', 'participants']);

        // filter function
        if ($request->filter) {
            // filter by title
            if ($request->judul) {
                $kelas->where('judul', 'like', '%'.$request->judul.'%');
            }
            // filter by date
            if ($request->tanggal) {                
                // must formatted as yyyy-mm-dd
                $kelas->whereDate('tanggal', 'like', '%'.$request->tanggal.'%');
            }
        }

        // order by
        $order = 'desc';    // default ordering
        if ($request->order) {
            $order = $request->order;
        }

        $kelas = $kelas->orderBy('tanggal', $order)->get();

        return response()->json([
            'success' => true,
            'message' => 'Permintaan berhasil.',
            'data' => $kelas
        ], 200);
    }

    public function detail($id)
    {
        $kelas = KelasAlumni::find($id)->first();

        if (!$kelas) {
            return response()->json([
                'success' => false,
                'message' => 'ID tidak ditemukan!',
                'data' => []
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Permintaan berhasil.',
            'data' => $kelas->load(['uploader', 'dataSpeaker', 'participants']),
        ], 200);
    }

    public function booking(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kelas_alumni_id' => 'required|integer',
            'alumni_id' => 'required|integer',
            'email' => 'required|email',
            'nama_lengkap' => 'required|string',
            'whatsapp' => 'required|min:11|max:13|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
                'data' => []
            ], 400);
        }

        $kelas = KelasAlumni::find($request->kelas_alumni_id)->first();
        if (!$kelas) {
            return response()->json([
                'success' => false,
                'message' => 'ID Kelas tidak ditemukan!',
                'data' => []
            ], 404);
        }

        $alumni = Alumni::find($request->alumni_id)->first();
        if (!$alumni) {
            return response()->json([
                'success' => false,
                'message' => 'ID Alumni tidak ditemukan!',
                'data' => []
            ], 404);
        }

        // restrict booking if alumni has been registered
        $bookExist = $kelas->with('participants')->whereHas('participants', function($query) use($alumni) {
            $query->where('alumni_id', $alumni->id);
        })->get();
        if (count($bookExist) > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Anda telah terdaftar dalam Kelas Alumni ini.',
                'data' => []
            ], 400);
        }

        $booking = BookingKelas::create([
            'kelas_alumni_id' => $request->kelas_alumni_id,
            'alumni_id' => $request->alumni_id,
            'email' => $request->email,
            'nama_lengkap' => $request->nama_lengkap,
            'whatsapp' => $request->whatsapp
        ]);

        if ($booking) {
            Mail::to($request->email)->send(new TicketMail($booking->load('kelas')));
            if (count(Mail::failures()) > 0) {
                $booking->delete();
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal mengirim email tiket, mohon periksa kembali email anda.',
                    'data' => []
                ], 400);
            }

            return response()->json([
                'success' => true,
                'message' => 'Booking berhasil! Silakan cek email untuk memeriksa tiket anda.',
                'data' => $booking
            ], 201);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Booking gagal!',
                'data' => []
            ], 404);
        }
    }

    public function unbook(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'alumni_id' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
                'data' => []
            ], 404);
        }

        $alumni = Alumni::find($request->alumni_id)->first();
        if (!$alumni) {
            return response()->json([
                'success' => false,
                'message' => 'ID tidak ditemukan!',
                'data' => []
            ], 404);
        }

        $booking = BookingKelas::where('alumni_id', $request->alumni_id)->first();
        if (!$booking) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak terdaftar pada kelas ini.',
                'data' => []
            ], 400);
        }

        $booking->delete();
        return response()->json([
            'success' => true,
            'message' => 'Anda berhasil membatalkan booking pada kelas ini.',
            'data' => []
        ], 200);
    }

    public function participants($id)
    {
        $kelas = KelasAlumni::find($id)->first();
        if (!$kelas) {
            return response()->json([
                'success' => false,
                'message' => 'ID tidak ditemukan!',
                'data' => []
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Permintaan berhasil.',
            'data' => $kelas->load(['participants'])
        ], 200);
    }

    public function resendTicket(Request $request)
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

        $alumni = Alumni::find($request->alumni_id)->first();        
        if (!$alumni) {
            return response()->json([
                'success' => false,
                'message' => 'ID tidak ditemukan!',
                'data' => []
            ], 404);
        }

        $booking = BookingKelas::where('alumni_id', $request->alumni_id)->first();
        if (!$booking) {
            return response()->json([
                'success' => false,
                'message' => 'Anda belum terdaftar pada Kelas Alumni ini.',
                'data' => []
            ], 400);
        }

        Mail::to($booking->email)->send(new TicketMail($booking->load('kelas')));
        if (count(Mail::failures()) > 0) {
            $booking->delete();
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengirim email tiket, mohon periksa kembali email anda.',
                'data' => []
            ], 400);
        }

        return response()->json([
            'success' => true,
            'message' => 'Tiket anda berhasil dikirim! Silakan cek email untuk memeriksanya.',
            'data' => $booking
        ], 200);
        
    }

    // future update maybe?
    public function updateEmailBooking(Request $request)
    {
        
    }

}
