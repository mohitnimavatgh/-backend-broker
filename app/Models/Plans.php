<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Plans extends Model
{
    use HasFactory,SoftDeletes;

    protected $hidden = ['created_at', 'updated_at','deleted_at'];
    protected $appends = ['is_plan_subscribe'];
    protected $fillable = [
        'broker_id',
        'plan_name',
        'plan_details',
        'plan_price',
        'plan_duration',
        'is_plan_free_trial',
        'stripe_plan_id',
        'stripe_plan_price_id'
    ];

    public function planFeatures()
    {
        return $this->hasMany(PlanFeatures::class,'plan_id');
    }

    public function broker()
    {
        return $this->belongsTo(User::class);
    }

    public function getIsPlanSubscribeAttribute(){
        $is_subscribe = PurchasePlan::where('plan_id',$this->id)->first();
        return $is_subscribe?true:false;
    }
}
