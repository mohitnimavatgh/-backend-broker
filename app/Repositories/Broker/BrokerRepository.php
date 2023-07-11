<?php

namespace App\Repositories\Broker;

use App\Interfaces\Broker\BrokerInterface as BrokerInterface;
use App\Models\User;
use App\Models\UserDetails;

class BrokerRepository implements BrokerInterface
{
    public function brokerList($request){
        if($request->search){
            $brokerList = User::where('role_name','broker')->where('name','like','%'.$request->search.'%')->with('userDetails')->get();
        }else{
           $brokerList = User::where('role_name','broker')->with('userDetails')->paginate(10);
        }
        return sendResponse(true,200,'success',$brokerList);
    }

    public function subscribeUser($request){
        $subscribeUser = User::select('users.id', 'users.name','users.email','users.mobile_no','users.address')
                        ->join('user_plan_purchase', 'users.id', '=', 'user_plan_purchase.user_id')
                        ->join('plans', 'user_plan_purchase.plan_id', '=', 'plans.id')
                        ->where('plans.broker_id', $request->id)
                        ->paginate(10);
        return sendResponse(true,200,'subscribe user',$subscribeUser);
    }
}