<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NotifAlumni extends Model
{
    protected $fillable = [
        'text', 
        'is_read', 
        'readed_at', 
        'alumni_id', 
        'created_at', 
        'updated_at'];

    public function alumni()
    {
        return $this->belongsTo('App\Alumni', 'alumni_id', 'id');
    }
}
