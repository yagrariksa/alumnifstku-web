<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FstNews extends Model
{
    protected $fillable = [
        'judul', 
        'link', 
        'gambar', 
        'created_at', 
        'updated_at', 
        'user_id'];

    public function uploader()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
}
