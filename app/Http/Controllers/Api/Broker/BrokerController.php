<?php

namespace App\Http\Controllers\Api\Broker;

use App\Http\Controllers\Controller;
use App\Interfaces\Broker\BrokerInterface;
use Illuminate\Http\Request;

class BrokerController extends Controller
{
    public function __construct(BrokerInterface $brokerInterface)
    {
        $this->broker = $brokerInterface;
    }

    public  function brokerList(Request $request){
        // try { 
            return $this->broker->brokerList($request);        
        // }catch (\Exception $e) {
        //     return $this->sendError(false, $e->getMessage() , $e->getCode());
        // }
    }
}
