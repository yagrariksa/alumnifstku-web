<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KelasAlumni extends Model
{
    protected $fillable = ['judul', 'kuota', 'tanggal', 'poster', 'deskripsi', 'kategori',
        'created_at', 'updated_at', 'user_id'];

    public function uploader()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function dataSpeaker()
    {
        return $this->hasMany('App\DataKelasAlumni', 'kelas_alumni_id', 'id');
    }

    public function participants()
    {
        return $this->hasMany('App\BookingKelas', 'kelas_alumni_id', 'id');
    }

}
