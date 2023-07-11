<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Laravel\Cashier\Billable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, Billable;

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
        'verified_otp',
        'updated_at',
        'created_at',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function userDetails()
    {
        return $this->hasMany(UserDetails::class,'user_id');
    }

    public function userPlan()
    {
        return $this->hasMany(PurchasePlan::class,'user_id');
    }

    public function brokerPlan()
    {
        return $this->hasMany(Plans::class,'broker_id');
    }
}
