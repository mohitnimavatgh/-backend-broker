<?php

namespace App\Repositories\User;

use App\Interfaces\User\UserCreditsInterface as UserCreditsInterface;
use App\Models\UserCredits;
use App\Models\RateOfInterests;
use App\Models\User;
use App\Models\Plans;

class UserCreditRepositor implements UserCreditsInterface
{
    public function userPalnCredit($request){

        $rateOfInterests = RateOfInterests::first();
        $plan = Plans::where('id',$request->plan_id)->first();
        $plan_price = $plan->plan_price;
        $rate = $rateOfInterests->rate_of_interest;
        $price = ($plan_price) * ($rate)/100;
      
        $purchasePlan =  UserCredits::create([
            'broker_id' => $plan->broker_id,
            'user_id' => $request->user_id,
            'plan_id' => $request->plan_id,
            'price' => $price,
            'rate_of_interest' => $rateOfInterests->rate_of_interest,
            'actual_price' => $plan->plan_price,
        ]);
        $purchasePlan = $this->userPalnCreditUpdate($plan->broker_id,$price);

        if($purchasePlan){
            return sendResponse(true, 200,'User Credit successfully',$purchasePlan);
        }
        return sendResponse(false,404, 'something went wrong',[]);
    }

    public function userPalnCreditUpdate($id,$price,$item='pay'){
       
        $rateOfInterests = User::find($id);  
        if($item == 'pay'){
            $userCredit = $rateOfInterests->user_credit + $price;
        }else{
            $userCredit = $rateOfInterests->user_credit - $price;
        }
        $rateOfInterests->user_credit = $userCredit;
        if($rateOfInterests->save()){
            return sendResponse(true, 200,'User Credit updated successfully',$rateOfInterests);
        }
        return sendResponse(false,404, 'something went wrong',[]);
    }   
}