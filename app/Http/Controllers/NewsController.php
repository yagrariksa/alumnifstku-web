<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\FstNews;
use Auth;

class NewsController extends Controller
{
    public function index()
    {
        $news = FstNews::paginate(10);
        return view('news.index')->with([
            'news' => $news
        ]);
    }

    public function create()
    {
        return view('news.create');
    }

    public function store(Request $request)
    {        
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string',
            'link' => 'required|string',
            'gambar' => 'required|string'
        ]);

        if ($validator->fails()) {
            flash('error')->error();
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $news = FstNews::create([
            'user_id' => Auth::user()->id,
            'judul' => $request->judul,
            'link' => $request->link,
            'gambar' => $request->gambar
        ]);
        flash('success')->success();
        return redirect()->route('news.index');
    }

    public function edit($id)
    {
        $news = FstNews::find($id);
        if (!$news) {
            flash('ID Berita tidak ditemukan!')->error();
            return redirect()->back();
        }

        return view('news.edit')->with([
            'news' => $news
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string',
            'link' => 'required|string',
            'gambar' => 'required|string'
        ]);

        if ($validator->fails()) {
            flash('error')->error();
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $news = FstNews::find($id);
        if (!$news) {
            flash('ID Berita tidak ditemukan!')->error();
            return redirect()->route('news.index');
        }

        if ($request->judul != $news->judul) {
            $news->update([
                'judul' => $request->judul
            ]);
        }
        
        if ($request->link != $news->link) {
            $news->update([
                'link' => $request->link
            ]);
        }
        
        if ($request->gambar != $news->gambar) {
            $news->update([
                'gambar' => $request->gambar
            ]);
        }

        flash('Success')->success();
        return redirect()->route('news.index');
    }

    public function destroy($id)
    {
        $news = FstNews::find($id);
        if (!$news) {
            flash('ID Berita tidak ditemukan!')->error();
            return redirect()->route('news.index');
        }

        $news->delete();
        
        flash('success')->success();
        return redirect()->route('news.index');
    }
}
