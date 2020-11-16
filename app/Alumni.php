<?php

namespace App;

// use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Alumni extends Authenticatable
{
    protected $fillable = ['email', 'username', 'password', 'api_token', 'token_registration', 'verified_at'];
    protected $hidden = ['password', 'token_registration'];    

    public function biodata()
    {
        return $this->hasOne('App\BiodataAlumni', 'alumni_id', 'id');
    }

    public function notif()
    {
        return $this->hasMany('App\NotifAlumni', 'alumni_id', 'id');
    }

    public function tracing()
    {
        return $this->hasMany('App\TracingAlumni', 'alumni_id', 'id');
    }

    public function komentar()
    {
        return $this->hasMany('App\KomentarSharingAlumni', 'alumni_id', 'id');
    }

    public function post()
    {
        return $this->hasMany('App\SharingAlumni', 'alumni_id', 'id');
    }

    public function tagged()
    {
        return $this->hasMany('App\TagPost', 'alumni_id', 'id');
    }
}
