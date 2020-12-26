<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;
use App\Alumni;
use App\BiodataAlumni;
use App\TracingAlumni;
use App\Mail\AccountVerificationMail;
use Storage;

class AlumniController extends Controller
{
    public function index()
    {
        $alumni = Alumni::with(['biodata'])->get();
        return view('alumni.index')->with([
            'alumnis' => $alumni
        ]);
    }

    public function create()
    {
        return view('alumni.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:alumnis',
            'username' => 'required|string|unique:alumnis',
            'password' => 'required|min:6|confirmed',
            'namalengkap' => 'required|string',
            'jurusan' => 'required|string',
            'angkatan' => 'required|string',
            'domisili' => 'required|string',
            'alamat' => 'required|string',
            'tempat_lahir' => 'requried|string',
            'tgl_lahir' => 'required|string',
            'umur' => 'required|integer',
            'jenis_kelamin' => 'required|string',
            'foto' => 'image|max:2048',
            'perusahaan' => 'required|string',
            'cluster' => 'required|string',
            'jabatan' => 'required|string',
            'thn_masuk' => 'required|string',
            'linkedin' => 'string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $alumni = Alumni::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'token_registration' => Str::random(50),
        ]);

        if ($alumni) {
            Mail::to($alumni->email)->send(new AccountVerificationMail($alumni));
            if (count(Mail::failures()) > 0) {
                $alumni->delete();
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $url;
            if ($request->hasFile('foto')) {
                $url = Storage::put('/', $request->foto);
            }

            // TODO : insert biodata alumni
        }
    }

    public function view($id)
    {
        $alumni = Alumni::find($id)->load([
            'biodata', 
            'tracing' => function($query) {
                $query->orderBy('created_at', 'desc');
            }
        ]);
               
        if (!$alumni) {
            flash('ID Alumni tidak ditemukan!')->error();
            return redirect()->back();
        }

        return view('alumni.view')->with([
            'alumni' => $alumni
        ]);

    }

    public function edit($id)
    {
        
    }

    public function update(Request $request, $id)
    {
        
    }

    public function destroy($id)
    {
        
    }
}
