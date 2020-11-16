<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TracingAlumni extends Model
{
    protected $fillable = ['perusahaan', 'tahun_masuk', 'jabatan', 'alumni_id', 'created_at', 'updated_at'];

    public function alumni()
    {
        return $this->belongsTo('App\Alumni', 'alumni_id', 'id');
    }
}
