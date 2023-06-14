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
}