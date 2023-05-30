<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'role_name',
        'mobile_no',
        'mobile_verified_at',
        'address',
        'photo',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'visible_password',
        'mobile_verified_at',
        'email_verified_at',
        'mobile_otp',
        'updated_at',
        'created_at',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

}
