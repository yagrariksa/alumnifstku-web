<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SharingAlumni extends Model
{
    protected $fillable = [
        'foto', 
        'deskripsi', 
        'alumni_id', 
        'created_at', 
        'updated_at'
    ];

    public function alumni()
    {
        return $this->belongsTo('App\Alumni', 'alumni_id', 'id');
    }

    public function tag()
    {
        return $this->hasOne('App\TagPost', 'sharing_alumni_id', 'id');
    }

    public function attribute()
    {
        return $this->hasOne('App\PostAttribute', 'sharing_alumni_id', 'id');
    }

    public function comment()
    {
        return $this->hasMany('App\KomentarSharingAlumni', 'sharing_alumni_id', 'id');
    }
}
