<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class PurchasePlan extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'user_plan_purchase';
    protected $hidden = ['created_at', 'updated_at','deleted_at'];
    protected $fillable = [
        'user_id',
        'plan_id',
        'expiry_date',
        'created_at'
    ];
    
    public function userPlan()
    {
        return $this->belongsTo(User::class);
    }
}
