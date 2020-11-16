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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/registration/alumni/{token}', 'AccountController@verifyAlumni')->name('alumni.verify');
Route::get('/reset-password/alumni/{token}', 'AccountController@resetPassword')->name('alumni.forgot');

Route::namespace('Api')->group(function() {
    Route::get('/alumni', 'TracingAlumniController@list')->name('list');
});