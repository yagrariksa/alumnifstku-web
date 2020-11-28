<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TagPost extends Model
{
    protected $fillable = ['alumni_id', 'sharing_alumni_id'];
    public $timestamps = false;

    public function post()
    {
        return $this->belongsTo('App\SharingAlumni', 'sharing_alumni_id', 'id');
    }

    public function alumni()
    {
        return $this->belongsTo('App\Alumni', 'alumni_id', 'id');
    }
}
