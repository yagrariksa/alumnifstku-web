<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Loker extends Model
{
    protected $fillable = ['judul', 'perusahaan', 'deskripsi', 'poster', 
        'link', 'created_at', 'updated_at'];

    public function uploader()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
}
