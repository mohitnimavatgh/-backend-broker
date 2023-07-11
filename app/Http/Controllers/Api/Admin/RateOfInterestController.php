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

    public function RateOfInterestsCreate(Request $request){
        try {
            $validator = Validator::make($request->all() ,[
                'rate_of_interest' => 'required',
            ]);

            if ($validator->fails())
            {
                return response()->json(['status' => false, 'status_code' => 422, 'message' => $validator->errors() ], 422);
            } 
            return $this->rateOfInterest->RateOfInterestsCreate($request);
        }catch (\Exception $e) {
            return $this->sendError($e, $e->getMessage() , $e->getCode());
       }
    }

    public function RateOfInterestsUpdate(Request $request){
        try {
            $validator = Validator::make($request->all() ,[
                'id' => 'required',
                'rate_of_interest' => 'required',
            ]);

            if ($validator->fails())
            {
                return response()->json(['status' => false, 'status_code' => 422, 'message' => $validator->errors() ], 422);
            } 
            return $this->rateOfInterest->RateOfInterestsUpdate($request);
        }catch (\Exception $e) {
            return $this->sendError($e, $e->getMessage() , $e->getCode());
       }
    }

    public function RateOfInterestsList(Request $request){
        try {
            return $this->rateOfInterest->RateOfInterestsList($request);
        }catch (\Exception $e) {
            return $this->sendError($e, $e->getMessage() , $e->getCode());
       }
    }

    public function RateOfInterestsDelete(Request $request){
        try {
            return $this->rateOfInterest->RateOfInterestsDelete($request);
        }catch (\Exception $e) {
            return $this->sendError($e, $e->getMessage() , $e->getCode());
       }
    }
    
}
