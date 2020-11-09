<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostAttribute extends Model
{
    protected $fillable = ['like_count', 'comment_count', 'post_id'];
    public $timestamps = false;

    public function post()
    {
        return $this->belongsTo('App\SharingAlumni', 'post_id', 'id');
    }
}
