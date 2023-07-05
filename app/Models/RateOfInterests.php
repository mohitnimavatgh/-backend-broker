<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class RateOfInterests extends Model
{
    use HasFactory,SoftDeletes;
    protected $hidden = ['created_at', 'updated_at','deleted_at'];
    protected $fillable = [
        'rate_of_interest',
    ];
}
