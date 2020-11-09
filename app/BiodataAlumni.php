<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BiodataAlumni extends Model
{
    protected $fillable = ['nama', 'angkatan', 'jurusan', 'linkedin', 'foto', 'alumni_id'];

    public function alumni()
    {
        return $this->belongsTo('App\Alumni', 'alumni_id', 'id');
    }
}
