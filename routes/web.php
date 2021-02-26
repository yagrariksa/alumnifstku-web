<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();
Route::get('/home',function() {
    return redirect()->route('dashboard.index');
})->name('home');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test','LokerController@testemail');

Route::get('/registration/alumni/{token}', 'AccountController@verifyAlumni')->name('alumni.verify');
Route::get('/reset-password/alumni/{token}', 'AccountController@resetPassword')->name('alumni.forgot');
Route::post('/reset-password/alumni','AccountController@postreset')->name('alumni.reset.post');

Route::namespace('Api')->group(function() {
    Route::get('/alumni', 'TracingAlumniController@list')->name('list');
});

Route::prefix('dashboard')->middleware('auth')->group(function() {
    Route::get('/', 'HomeController@index')->name('dashboard.index');
});

Route::prefix('my')->middleware('auth')->group(function(){
});

Route::prefix('alumni')->middleware('auth')->group(function() {
    Route::get('/', 'AlumniController@index')->name('alumni.index');
    Route::get('/create', 'AlumniController@create')->name('alumni.create');
    Route::post('/store', 'AlumniController@store')->name('alumni.store');
    Route::get('/edit/{id}', 'AlumniController@edit')->name('alumni.edit');
    Route::get('/view/{id}', 'AlumniController@view')->name('alumni.view');
    Route::post('/update/{id}', 'AlumniController@update')->name('alumni.update');
    Route::post('/destroy/{id}', 'AlumniController@destroy')->name('alumni.destroy');
});

Route::prefix('news')->middleware('auth')->group(function() {
    Route::get('/', 'NewsController@index')->name('news.index');
    Route::get('/create', 'NewsController@create')->name('news.create');
    Route::post('/store', 'NewsController@store')->name('news.store');
    Route::get('/edit/{id}', 'NewsController@edit')->name('news.edit');
    Route::post('/update/{id}', 'NewsController@update')->name('news.update');
    Route::get('/view/{id}', 'NewsController@view')->name('news.view');
    Route::get('/destroy/{id}', 'NewsController@destroy')->name('news.destroy');
});

Route::prefix('kelas')->middleware('auth')->group(function() {
    Route::get('/', 'KelasController@index')->name('kelas.index');
    Route::get('/create', 'KelasController@create')->name('kelas.create');
    Route::post('/store', 'KelasController@store')->name('kelas.store');
    Route::get('/edit/{id}', 'KelasController@edit')->name('kelas.edit');
    Route::post('/update/{id}', 'KelasController@update')->name('kelas.update');
    Route::get('/view/{id}', 'KelasController@view')->name('kelas.view');
    Route::get('/destroy/{id}', 'KelasController@destroy')->name('kelas.destroy');

    Route::get('/pembicara/{id}','KelasController@pembicara')->name('kelas.pembicara.index');
    Route::post('/pembicara/{id}/store','KelasController@pembicarastrore')->name('kelas.pembicara.store');
    Route::get('/pembicara/{id}/destroy/{pembicara}','KelasController@pembicaradestroy')->name('kelas.pembicara.destroy');
    
    Route::prefix('peserta')->group(function() {
        Route::get('/', 'KelasController@participant')->name('kelas.participant');
    });

});

Route::prefix('loker')->middleware('auth')->group(function() {
    Route::get('/', 'LokerController@index')->name('loker.index');
    Route::get('/create', 'LokerController@create')->name('loker.create');
    Route::post('/store', 'LokerController@store')->name('loker.store');
    Route::get('/edit/{id}', 'LokerController@edit')->name('loker.edit');
    Route::post('/update/{id}', 'LokerController@update')->name('loker.update');
    Route::get('/view/{id}', 'LokerController@view')->name('loker.view');
    Route::get('/destroy/{id}', 'LokerController@destroy')->name('loker.destroy');
});