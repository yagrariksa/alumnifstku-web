<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookingKelas extends Model
{
    protected $fillable = ['kelas_alumni_id', 'alumni_id', 'email', 'nama_lengkap',
                'whatsapp', 'created_at', 'updated_at'];

    public function kelas()
    {
        return $this->belongsTo('App\KelasAlumni', 'kelas_alumni_id', 'id');
    }

    public function owner()
    {
        return $this->belongsTo('App\Alumni', 'alumni_id', 'id');
    }
}
