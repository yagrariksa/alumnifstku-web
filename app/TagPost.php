<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TagPost extends Model
{
    protected $fillable = ['alumni_id', 'post_id'];
    public $timestamps = false;

    public function post()
    {
        return $this->belongsTo('App\SharingAlumni', 'post_id', 'id');
    }

    public function alumni()
    {
        return $this->belongsTo('App\Alumni', 'alumni_id', 'id');
    }
}
