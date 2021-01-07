<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Loker extends Model
{
    protected $fillable = ['jabatan', 'perusahaan', 'deskripsi', 'poster','user_id',
        'link', 'cluster', 'jurusan', 'deadline', 'created_at', 'updated_at'];

    public function uploader()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
}
