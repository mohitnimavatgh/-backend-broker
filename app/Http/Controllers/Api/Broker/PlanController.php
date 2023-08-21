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

    public function allPlanLists(Request $request){
       try { 
            return $this->plan->allPlanLists($request);        
       }catch (\Exception $e) {
           return $this->sendError(false, $e->getMessage() , $e->getCode());
       }
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
    public function planCreate(PlanRequest $request){
        try { 
            return $this->plan->planCreate($request);        
        }catch (\Exception $e) {
            return $this->sendError(false, $e->getMessage() , $e->getCode());
        }
    }

     //For Plan Creaet OR Update 
     public function planUpdate(PlanRequest $request){
        try { 
            $validator = Validator::make($request->all() ,['id' => 'required']);

            if ($validator->fails())
            {
                return response()->json(['status' => false, 'status_code' => 422, 'message' => $validator->errors() ], 422);
            } 
            return $this->plan->planUpdate($request);        
        }catch (\Exception $e) {
            return $this->sendError(false, $e->getMessage() , $e->getCode());
        }
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
    public function planFeaturesList(Request $request){
        // try { 
            return $this->plan->planFeaturesList($request);        
        // }catch (\Exception $e) {
        //     return $this->sendError(false, $e->getMessage() , $e->getCode());
        // }
    }

    //Get the Plan Features
    public function getPlanFeatures(Request $request){
        try { 
            return $this->plan->getPlanFeatures($request);
        }catch (\Exception $e) {
            return $this->sendError(false, $e->getMessage() , $e->getCode());
        }
    }

    //For plan Features Creaet 
    public function planFeaturesCreate(Request $request){
        try { 
            $validator = Validator::make($request->all() ,['plan_id' => 'required', 'plan_feature' => 'required']);

            if ($validator->fails())
            {
                return response()->json(['status' => false, 'status_code' => 422, 'message' => $validator->errors() ], 422);
            } 
            return $this->plan->planFeaturesCreate($request);        
        }catch (\Exception $e) {
            return $this->sendError(false, $e->getMessage() , $e->getCode());
        }
    }

    //For plan Features Update
    public function planFeaturesUpdate(Request $request){
        try { 
            $validator = Validator::make($request->all() ,['plan_id' => 'required','id' => 'required','plan_feature' => 'required']);

            if ($validator->fails())
            {
                return response()->json(['status' => false, 'status_code' => 422, 'message' => $validator->errors() ], 422);
            } 
            return $this->plan->planFeaturesUpdate($request);        
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
