<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', 'address', 'city', 'country','phone_number',
    ];

   
public function getFullNameAttribute()
{
    return $this->first_name. ' '. $this->last_name;
}

    
    protected $hidden = [
        'password', 'remember_token',
    ];

    
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function orders()
{
    return $this->hasMany(Order::class);
}

public function comments()
{
    return $this->hasMany(Comment::class);
}

public function profile()
{
    return $this->hasOne(Profile::class);
}

public function cartt()
    {
        return $this->hasOne(Cartt::class);
    }
}
