<?php

namespace App\Http\Controllers\Api\Broker;

use App\Http\Controllers\Controller;
use App\Http\Requests\broker\PlanRequest;
use App\Interfaces\Broker\PlanInterface;
use Illuminate\Http\Request;
use Validator;

class PlanController extends Controller
{
    public function __construct(PlanInterface $planInterface)
    {
        $this->plan = $planInterface;
    }

    //Get all the plans
    public function planList(Request $request){
        try { 
             return $this->plan->planList($request);        
        }catch (\Exception $e) {
            return $this->sendError(false, $e->getMessage() , $e->getCode());
        }
    }

    //Get the Plan
    public function getPlan($id){
        try { 
            return $this->plan->getPlan($id);
        }catch (\Exception $e) {
            return $this->sendError(false, $e->getMessage() , $e->getCode());
        }
    }

    //For Plan Creaet OR Update 
    public function planCreateOrUpdate(PlanRequest $request){
        // try { 
            return $this->plan->planCreateOrUpdate($request);        
        // }catch (\Exception $e) {
        //     return $this->sendError(false, $e->getMessage() , $e->getCode());
        // }
    }

    //For Plan Delete
    public function planDelete($id){
        try { 
            return $this->plan->planDelete($id);
        }catch (\Exception $e) {
            return $this->sendError(false, $e->getMessage() , $e->getCode());
        }
    }


    //Get all the plan Features
    public function planFeaturesList(){
        try { 
            return $this->plan->planFeaturesList();        
        }catch (\Exception $e) {
            return $this->sendError(false, $e->getMessage() , $e->getCode());
        }
    }

    //Get the Plan Features
    public function getPlanFeatures($id){
        try { 
            return $this->plan->getPlanFeatures($id);
        }catch (\Exception $e) {
            return $this->sendError(false, $e->getMessage() , $e->getCode());
        }
    }

    //For plan Features Creaet OR Update 
    public function planFeaturesCreateOrUpdate(Request $request){
        try { 
            $validator = Validator::make($request->all() ,['plan_id' => 'required', 'plan_feature' => 'required']);

            if ($validator->fails())
            {
                return response()->json(['status' => false, 'status_code' => 422, 'message' => $validator->errors() ], 422);
            } 
            return $this->plan->planFeaturesCreateOrUpdate($request);        
        }catch (\Exception $e) {
            return $this->sendError(false, $e->getMessage() , $e->getCode());
        }
    }

    //For plan Features Delete
    public function planFeaturesDelete($id){
        try { 
            return $this->plan->planFeaturesDelete($id);
        }catch (\Exception $e) {
            return $this->sendError(false, $e->getMessage() , $e->getCode());
        }
    }
}
