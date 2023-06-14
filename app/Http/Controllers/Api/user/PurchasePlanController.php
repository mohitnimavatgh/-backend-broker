<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Interfaces\User\PurchasePlanInterface;
use Illuminate\Http\Request;
use Validator;

class PurchasePlanController extends Controller
{
    public function __construct(PurchasePlanInterface $purchasePlanRepositor)
    {
        $this->purchasePlan = $purchasePlanRepositor;
    }

    public  function userPurchasePlan(Request $request){
        try {
            $validator = Validator::make($request->all(),
            [
               'user_id' => 'required',
               'plan_id' => 'required',
            ]);

            if ($validator->fails())
            {
                return response()
                    ->json(['status' => false,'status_code' => 422, 'message' => $validator->errors() ], 422);
            }    
            return $this->purchasePlan->userPurchasePlan($request);
        }catch (\Exception $e) {
            return $this->sendError($e, $e->getMessage() , $e->getCode());
        }
    }

    public  function getuserPurchasePlan(Request $request){
        try {
            return $this->purchasePlan->getuserPurchasePlan($request);
        }catch (\Exception $e) {
            return $this->sendError($e, $e->getMessage() , $e->getCode());
        }
    }
}
