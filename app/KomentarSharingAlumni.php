<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KomentarSharingAlumni extends Model
{
    protected $fillable = [
        'text', 
        'alumni_id', 
        'post_id', 
        'created_at', 
        'updated_at'
    ];

    public function alumni()
    {
        return $this->belongsTo('App\Alumni', 'alumni_id', 'id');
    }

    public function post()
    {
        return $this->belongsTo('App\SharingAlumni', 'post_id', 'id');
    }
}
