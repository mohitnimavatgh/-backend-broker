<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\Admin\RateOfInterestInterface;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class RateOfInterestController extends Controller
{
    public function __construct(RateOfInterestInterface $RateOfInterestInterface)
    {
        $this->rateOfInterest = $RateOfInterestInterface;
    }

    public function RateOfInterestsCreateOrUpdate(Request $request){
        try {
            $validator = Validator::make($request->all() ,[
                'rate_of_interest' => 'required',
            ]);

            if ($validator->fails())
            {
                return response()->json(['status' => false, 'status_code' => 422, 'message' => $validator->errors() ], 422);
            } 
            return $this->rateOfInterest->RateOfInterestsCreateOrUpdate($request);
        }catch (\Exception $e) {
            return $this->sendError($e, $e->getMessage() , $e->getCode());
       }
    }
}
