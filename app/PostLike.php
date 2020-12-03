<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostLike extends Model
{
    protected $fillable = ['alumni_id', 'sharing_alumni_id'];

    public function post()
    {
        return $this->belongsTo('App\SharingAlumni', 'sharing_alumni_id', 'id');
    }
}
