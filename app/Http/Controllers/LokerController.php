<?php

namespace App\Http\Controllers;

use App\Loker;
use Illuminate\Http\Request;
use Validator;
use Auth;

class LokerController extends Controller
{
    public function index(){
        echo("INDEX");
    }

    public function create(){
        echo("CREATE");

    }

    public function store(Request $request){
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

        $news = Loker::create([
            'user_id'    => Auth::user()->id,
            'jabatan'    => $request->jabatan,
            'perusahaan' => $request->perusahaan,
            'deskripsi'  => $request->deskripsi,
            'poster'     => $request->poster,
            'link'       => $request->link,
            'cluster'    => $request->cluster,
            'jurusan'    => $request->jurusan,
            'deadline'   => $request->deadline,
        ]);
        flash('success')->success();
        return redirect()->route('news.index');

    }

    public function view($id){

    }

    public function edit($id){

    }

    public function update(Request $request, $id){

    }

    public function destroy($id){

    }
}
