<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $guard = 'admin';
   
    protected $fillable = [
        'name', 'email', 'password','role'
    ];

    
    protected $hidden = [
        'password', 'remember_token',
    ];

    

    public function getFullNameAttribute()
{
    return $this->name;
}

    public function profile()
{
    return $this->hasOne(Profile::class);
}

public function settings()
{
    return $this->belongsToMany(Setting::class, 'admin_settings', 'setting_id', 'admin_id');
}

}