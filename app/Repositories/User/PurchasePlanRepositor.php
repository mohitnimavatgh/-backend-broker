<?php

namespace App\Repositories\User;

use App\Interfaces\User\PurchasePlanInterface as PurchasePlanInterface;
use App\Repositories\User\UserCreditRepositor;
use App\Models\PurchasePlan;
use App\Models\User;

class PurchasePlanRepositor implements PurchasePlanInterface
{
    public function userPurchasePlan($request){
        $purchasePlan =  PurchasePlan::where('plan_id',$request->plan_id)->first();
        if($purchasePlan && $request->update_plan_id){
            $new_plan_id = $request->update_plan_id;
            $purchasePlan->plan_id = isset($new_plan_id)?$new_plan_id:$request->plan_id;
            $purchasePlan->save();
        }else{
            $expiry_date = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . ' +1 day'));
            $purchasePlan =  PurchasePlan::create([
                'user_id' => $request->user_id,
                'plan_id' => $request->plan_id,
                'plan_price' => $request->plan_price,
                'expiry_date' => $expiry_date,
            ]);
            $userCreditRepositor = app(UserCreditRepositor::class);
            $response =  $userCreditRepositor->userPalnCredit($request);
        }
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