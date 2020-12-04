<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::namespace('Api')->group(function() {
    Route::middleware('auth:api')->get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/register', 'AuthController@register')->name('register');
    Route::post('/login', 'AuthController@login')->name('login');
    Route::post('/forgot', 'AuthController@forgotPassword')->name('forgot');
    Route::post('/resend-verification', 'AuthController@resendVerification')->name('resend');

    // Remember to set Header Accept as application/json
    Route::prefix('alumni')->middleware('auth:api')->group(function() {
        Route::get('/', 'TracingAlumniController@list')->name('list');
        Route::get('/{id}', 'TracingAlumniController@detail')->name('detail');
    });

    Route::prefix('loker')->middleware('auth:api')->group(function() {
        Route::get('/', 'LokerController@list')->name('list');
        Route::get('/{id}', 'LokerController@detail')->name('detail');
    });

    Route::prefix('news')->middleware('auth:api')->group(function() {
        Route::get('/', 'NewsController@list')->name('list');
        Route::get('/{id}', 'NewsController@detail')->name('detail');
    });

    Route::prefix('kelas')->middleware('auth:api')->group(function() {
        Route::get('/', 'KelasAlumniController@list')->name('list');
        Route::get('/{id}', 'KelasAlumniController@detail')->name('detail');
        Route::get('/{id}/participants', 'KelasAlumniController@participants')->name('participants');
        Route::post('/book', 'KelasAlumniController@booking')->name('book');
        Route::post('/unbook', 'KelasAlumniController@unbook')->name('unbook');
        Route::post('/resend-ticket', 'KelasAlumniController@resendTicket')->name('resend-ticket');
        // future update maybe?
        // Route::post('/update-email', 'KelasAlumniController@updateEmailBooking')->name('resend-ticket');
    });

    Route::prefix('sharing')->middleware('auth:api')->group(function() {
        Route::get('/', 'SharingMemoryController@timeline')->name('timeline');
        Route::get('/my', 'SharingMemoryController@myPost')->name('my');
        Route::get('/{id}', 'SharingMemoryController@detail')->name('detail');
        Route::post('/{id}/like', 'SharingMemoryController@like')->name('like');
        Route::post('/{id}/unlike', 'SharingMemoryController@unlike')->name('unlike');
        Route::prefix('/{id}/comment')->group(function() {
            Route::get('/', 'SharingMemoryController@comments');
            Route::post('/', 'SharingMemoryController@postComment')->name('post');
            Route::post('/remove/{commentId}', 'SharingMemoryController@removeComment')->name('remove');
        });
        Route::post('/', 'SharingMemoryController@postMemory')->name('post');
        Route::post('/{id}/update', 'SharingMemoryController@updateMemory')->name('update');
        Route::post('/{id}/remove', 'SharingMemoryController@removeMemory')->name('remove');
    });

    Route::get('/pic', 'PictureController@show')->name('show');
});    

