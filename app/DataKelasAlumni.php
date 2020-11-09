<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DataKelasAlumni extends Model
{
    protected $fillable = ['pembicara', 'tentang', 'foto', 'kelas_alumni_id'];
    public $timestamps = false;

    public function kelas()
    {
        return $this->belongsTo('App\KelasAlumni', 'kelas_alumni_id', 'id');
    }
    
}
