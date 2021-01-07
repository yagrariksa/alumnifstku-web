<?php

namespace App\Http\Controllers;

use App\Loker;
use Illuminate\Http\Request;
use Validator;
use Auth;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class LokerController extends Controller
{
    public function index(){
        $loker = Loker::paginate(10);

        return view('loker.index')->with([
            'loker'=> $loker
        ]);
    }

    public function create(){
        return view('loker.create');

    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'jabatan'    => 'required|string', 
            'perusahaan' => 'required|string', 
            'deskripsi'  => 'required|string', 
            'poster'     => 'string', 
            'link'       => 'string', 
            'cluster'    => 'required|string', 
            'jurusan'    => 'required|string', 
            'deadline'   => 'required|string',
        ]);

        if ($validator->fails()) {
            dd($validator);
            flash('error')->error();
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $loker = Loker::create([
            'user_id'    => Auth::user()->id,
            'jabatan'    => $request->jabatan,
            'perusahaan' => $request->perusahaan,
            'deskripsi'  => $request->deskripsi,
            'poster'     => $request->poster,
            'link'       => $request->link,
            'cluster'    => $request->cluster,
            'jurusan'    => $request->jurusan,
            'deadline'   => (string)$request->deadline,
        ]);
        flash('success')->success();
        return redirect()->route('loker.index');

    }

    public function view($id){

        $loker = Loker::find($id);

        if(!$loker){
            flash('ID Loker tidak ditemukan!')->error();
            return redirect()->back();
        }

        return view('loker.view')->with([
            'loker' => $loker
        ]);

    }

    public function edit($id)
    {
        $loker = Loker::find($id);

        if(!$loker){
            flash('ID Loker tidak ditemukan!')->error();
            return redirect()->back();
        }

        return view('loker.edit')->with([
            'loker' => $loker
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'jabatan'    => 'required|string', 
            'perusahaan' => 'required|string', 
            'deskripsi'  => 'required|string', 
            'poster'     => 'required|string', 
            'link'       => 'required|string', 
            'cluster'    => 'required|string', 
            'jurusan'    => 'required|string', 
            'deadline'   => 'required|string',
        ]);

        if ($validator->fails()) {
            flash('error')->error();
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $loker = Loker::find($id);
        if (!$loker) {
            flash('ID Loker tidak ditemukan!')->error();
            return redirect()->route('loker.index');
        }

        if ($request->jabatan != $loker->jabatan) {
            $loker->update([
                'jabatan' => $request->jabatan
            ]);
        }

        if ($request->perusahaan != $loker->perusahaan) {
            $loker->update([
                'perusahaan' => $request->perusahaan
            ]);
        }

        if ($request->deskripsi != $loker->deskripsi) {
            $loker->update([
                'deskripsi' => $request->deskripsi
            ]);
        }

        if ($request->poster != $loker->poster) {
            $loker->update([
                'poster' => $request->poster
            ]);
        }

        if ($request->link != $loker->link) {
            $loker->update([
                'link' => $request->link
            ]);
        }

        if ($request->cluster != $loker->cluster) {
            $loker->update([
                'cluster' => $request->cluster
            ]);
        }

        if ($request->jurusan != $loker->jurusan) {
            $loker->update([
                'jurusan' => $request->jurusan
            ]);
        }

        if ($request->deadline != $loker->deadline) {
            $loker->update([
                'deadline' => $request->deadline
            ]);
        }

        flash('Success')->success();
        return redirect()->route('loker.index');
    }

    public function destroy($id)
    {
        $loker = Loker::find($id);
        if (!$loker) {
            flash('ID Loker tidak ditemukan!')->error();
            return redirect()->route('loker.index');
        }

        $loker->delete();

        flash('Success')->success();
        return redirect()->route('loker.index');
    }
}
