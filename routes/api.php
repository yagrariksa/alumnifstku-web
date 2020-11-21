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
});    

