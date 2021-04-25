<?php

namespace App\Http\Controllers;

use App\Alumni;
use App\BiodataAlumni;
use App\Loker;
use App\Mail\LokerMail;
use Illuminate\Http\Request;
use Validator;
use Auth;
use DateTime;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;

class LokerController extends Controller
{
    public function index()
    {
        $loker = Loker::with('uploader')->orderBy('updated_at','DESC')->paginate(10);

        foreach($loker as $l) {
            $l->deadline = new DateTime($l->deadline);
              
            $l->deadline = $l->deadline->format('d-M-Y');
        }

        return view('loker.index')->with([
            'loker' => $loker
        ]);
    }

    public function create()
    {
        return view('loker.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'jabatan'    => 'required|string',
            'perusahaan' => 'required|string',
            'deskripsi'  => 'required|string',
            'poster'     => '',
            'link'       => '',
            'cluster'    => 'required|string',
            'deadline'   => 'required|string',
        ]);

        if ($validator->fails()) {
            flash('error')->error();
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $jurusan = "";

        if ($request['sistem_informasi']) {
            $jurusan .= "Sistem Informasi,";
        }
        if ($request['teknik_biomedis']) {
            $jurusan .= 'Teknik Biomedis,';
        }
        if ($request['teknik_lingkungan']) {
            $jurusan .= 'Teknik Lingkungan,';
        }
        if ($request['matematika']) {
            $jurusan .= 'Matematika,';
        }
        if ($request['fisika']) {
            $jurusan .= 'Fisika,';
        }
        if ($request['kimia']) {
            $jurusan .= 'Kimia,';
        }
        if ($request['biologi']) {
            $jurusan .= 'Biologi,';
        }
        if ($request['statistika']) {
            $jurusan .= 'Statistika,';
        }

        $loker = Loker::create([
            'user_id'    => Auth::user()->id,
            'jabatan'    => $request->jabatan,
            'perusahaan' => $request->perusahaan,
            'deskripsi'  => $request->deskripsi,
            'poster'     => $request->poster,
            'link'       => $request->link,
            'cluster'    => $request->cluster,
            'jurusan'    => $jurusan,
            'deadline'   => (string)$request->deadline . " 00:00:00",
        ]);
        
        $res = $this->sendemail($jurusan,$loker);

        if(!$res){
            return redirect()->route('loker.index')->with('error','gagal');
        }
        flash('success')->success();
        return redirect()->route('loker.index');
    }
    
    public function testemail()
    {
        Artisan::call('config:clear');
        Artisan::call('config:cache');
        Artisan::call('cache:clear');
        // $loker = Loker::first();
        // $this->sendemail('Sistem Informasi',$loker);
        echo "SUCCESS";
    }

    public function sendemail($listjurusan, $data)
    {
        $jurusan = explode(",",$listjurusan);
        foreach($jurusan as $j)
        {
            // cari alumni dengan jurusan tersebut
            $bio_al = BiodataAlumni::where('jurusan',$j)->get();
            foreach($bio_al as $a)
            {
                // $alumni = Alumni::where('',$a->alumni_id)->first();
                $alumni = $a->alumni;
                // dapatkan emailnya
                $email = $alumni->email;
    
                // masukin data ke Email
                Mail::to($email)->send(new LokerMail($data));
                if(count(Mail::failures()) > 0){
                    return false;
                }
            }
        }
        return true;
    }

    public function view($id)
    {

        $loker = Loker::find($id);

        if (!$loker) {
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

        if (!$loker) {
            flash('ID Loker tidak ditemukan!')->error();
            return redirect()->back();
        }

        $jurusan = explode(",",$loker['jurusan']);
        $tanggal = explode(" ",$loker['deadline']);
        $loker->deadline = $tanggal[0];
        

        return view('loker.edit')->with([
            'loker' => $loker,
            'jurusan' => $jurusan,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'jabatan'    => 'required|string',
            'perusahaan' => 'required|string',
            'deskripsi'  => 'required|string',
            'poster'     => '',
            'link'       => '',
            'cluster'    => 'required|string',
            'deadline'   => 'required|string',
        ]);

        if ($validator->fails()) {
            flash('error')->error();
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $jurusan = "";

        if ($request['sistem_informasi']) {
            $jurusan .= "Sistem Informasi,";
        }
        if ($request['teknik_biomedis']) {
            $jurusan .= 'Teknik Biomedis,';
        }
        if ($request['teknik_lingkungan']) {
            $jurusan .= 'Teknik Lingkungan,';
        }
        if ($request['matematika']) {
            $jurusan .= 'Matematika,';
        }
        if ($request['fisika']) {
            $jurusan .= 'Fisika,';
        }
        if ($request['kimia']) {
            $jurusan .= 'Kimia,';
        }
        if ($request['biologi']) {
            $jurusan .= 'Biologi,';
        }
        if ($request['statistika']) {
            $jurusan .= 'Statistika,';
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

        if ($jurusan != $loker->jurusan) {
            $loker->update([
                'jurusan' => $jurusan
            ]);
        }

        if ($request->deadline != $loker->deadline) {
            $loker->update([
                'deadline' => $request->deadline . " 00:00:00"
            ]);
        }

        $res = $this->sendemail($jurusan,$loker);
        if(!$res){
            return redirect()->route('loker.index')->with('error','gagal');
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
