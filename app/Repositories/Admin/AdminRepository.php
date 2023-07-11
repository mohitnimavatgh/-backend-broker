<?php

namespace App\Repositories\Admin;

use App\Interfaces\Admin\AdminInterface as AdminInterface;
use App\Models\User;
use App\Models\Plans;
use App\Models\PlanFeatures;
use DB;

class AdminRepository implements AdminInterface
{
    public function getUserList($request)
    {
        $getUserAll = [];
        if($request->role == 'user'){
            $getUserAll = User::select(['id','name','role_name','email','mobile_no','address'])->where('role_name',$request->role)->paginate(10);
        }elseif($request->role == 'broker'){
            $getUserAll = User::select(['id','name','role_name','email','mobile_no','address'])->where('role_name',$request->role)->paginate(10);
        }elseif($request->role == 'sales and marketing'){
            $getUserAll = User::select(['id','name','role_name','email'])->where('role_name',$request->role)->paginate(10);
        }else{
            $getUserAll = User::select(['id','name','role_name','email','mobile_no','address'])->where('role_name','!=','admin')->paginate(10);
        }
        return sendResponse(true, 200,'get user successfully',$getUserAll);
    }
    
    public function getBrokerPlanList($request)
    {
        $getPlan = []; 
        if($request->broker_id){
            $getPlan = Plans::select(['id','broker_id','plan_name','plan_price','plan_duration'])->where('broker_id',$request->broker_id)->paginate(10);
        }else{
            $getPlan = Plans::select(['id','broker_id','plan_name','plan_price','plan_duration'])->with(['broker:id,name'])->paginate(10);
        }
        return sendResponse(true, 200,'get plan list successfully',$getPlan);
    }

    public function getPlanUser($request)
    {  
        $getPlanUser = [];
        if($request->plan_id){

            $getPlanUser = DB::table('users')
            ->join('user_plan_purchase', 'users.id', '=', 'user_plan_purchase.user_id')
            ->select('users.id','users.name', 'users.email','users.mobile_no')
            ->where('user_plan_purchase.plan_id', '=', $request->plan_id)
            ->paginate(10);
        }
        return sendResponse(true, 200,'get plan list successfully',$getPlanUser);
    }

    public function planFeaturesList($request){
        $planFeatures = [];
        if($request->plan_id){
            $planFeatures = PlanFeatures::where('plan_id',$request->plan_id)->with(['plan:id,plan_name'])->paginate(10);
        }else{
            $planFeatures = PlanFeatures::with(['plan:id,plan_name'])->paginate(10);
        }
        return sendResponse(true,200,'Plan Features List',$planFeatures);
    }
}