<?php

namespace App\Repositories\User;

use App\Interfaces\User\PurchasePlanInterface as PurchasePlanInterface;
use App\Models\PurchasePlan;
use App\Models\User;

class PurchasePlanRepositor implements PurchasePlanInterface
{
    public function userPurchasePlan($request){
        $expiry_date = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . ' +1 day'));

        $purchasePlan =  PurchasePlan::create([
            'user_id' => $request->user_id,
            'plan_id' => $request->plan_id,
            'expiry_date' => $expiry_date,
        ]);
        return sendResponse(true,200,'plan purchase successfully',$purchasePlan);
    }

    public function getuserPurchasePlan($request){
        if($request->id){
            $userPlan = User::where('role_name','user')->where('id',$request->id)->with('userPlan')->get();
        }else{
            $userPlan = User::where('role_name','user')->with('userPlan')->get();
        }
        return sendResponse(true,200,'get user plans',$userPlan);
    }
}