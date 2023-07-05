<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserCredits extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'broker_id',
        'user_id',
        'plan_id',
        'price',
        'rate_of_interest',
        'actual_price',
    ];

    protected $hidden = [
        'updated_at',
        'created_at',
        'deleted_at',
    ];
}
