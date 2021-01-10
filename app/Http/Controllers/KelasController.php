<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Alumni;
use App\KelasAlumni;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = KelasAlumni::paginate(10);

        foreach($kelas as $k) {
            $explode = explode(" ", $k->tanggal);
            $k->tanggal = new DateTime($explode[0]);
              
            $k->tanggal = $k->tanggal->format('d-M-Y') . " " . $explode[1];
        }

        return view('kelas.index', [
            'kelas' => $kelas,
        ]);
    }

    public function create()
    {
        return view('kelas.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul'    => 'required|string',
            'kuota' => 'required',
            'deskripsi'  => 'required|string',
            'poster'     => '',
            'kategori'    => 'required|string',
            'tanggal'   => 'required|string',
        ]);

        if ($validator->fails()) {
            flash('error')->error();
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $explode = explode('T',$request->tanggal);
        $explode = join(" ", $explode) . ":00";

        $kelas = KelasAlumni::create([
            'judul'     => $request->judul,
            'kuota'     => $request->kuota,
            'deskripsi' => $request->deskripsi,
            'poster'    => $request->poster,
            'kategori'  => $request->kategori,
            'tanggal'   => $explode,
            'user_id'   => Auth::user()->id,     
        ]);

        flash('success')->success();
        return redirect()->route('kelas.index');
    }

    public function edit($id)
    {
        $kelas = KelasAlumni::find($id);

        $explode = explode(" ", $kelas->tanggal);
        $kelas->tanggal = $explode[0] . "T" . substr($explode[1],0,5);

        return view('kelas.edit',[
            'kelas' => $kelas,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'judul'    => 'required|string',
            'kuota' => 'required',
            'deskripsi'  => 'required|string',
            'poster'     => '',
            'kategori'    => 'required|string',
            'tanggal'   => 'required|string',
        ]);

        if ($validator->fails()) {
            flash('error')->error();
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $explode = explode('T',$request->tanggal);
        $explode = join(" ", $explode) . ":00";

        $kelas = KelasAlumni::find($id);

        if ($request->judul != $kelas->judul) {
            $kelas->update([
                'judul' => $request->judul
            ]);
        }
        if ($request->kuota != $kelas->kuota) {
            $kelas->update([
                'kuota' => $request->kuota
            ]);
        }
        if ($request->deskripsi != $kelas->deskripsi) {
            $kelas->update([
                'deskripsi' => $request->deskripsi
            ]);
        }
        if ($request->poster != $kelas->poster) {
            $kelas->update([
                'poster' => $request->poster
            ]);
        }
        if ($request->kategori != $kelas->kategori) {
            $kelas->update([
                'kategori' => $request->kategori
            ]);
        }
        if ($request->tanggal != $kelas->tanggal) {
            $kelas->update([
                'tanggal' => $request->tanggal
            ]);
        }

        flash('success')->success();
        return redirect()->route('kelas.index');
    }

    public function destroy($id)
    {
        KelasAlumni::find($id)->delete();

        flash('success')->success();
        return redirect()->route('kelas.index');
    }
}
