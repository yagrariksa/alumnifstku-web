<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BiodataAlumni extends Model
{
    protected $fillable = [
        'nama', 
        'angkatan', 
        'alamat', 
        'umur', 
        'jenis_kelamin', 
        'ttl',          
        'jurusan', 
        'cluster',
        'linkedin', 
        'foto', 
        'alumni_id', 
        'created_at', 
        'updated_at'];

    public function alumni()
    {
        return $this->belongsTo('App\Alumni', 'alumni_id', 'id');
    }
}
