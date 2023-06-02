<?php 

namespace App\Repositories\Broker;
use App\Interfaces\Broker\PlanInterface as PlanInterface;
use App\Models\UserDetails;
use App\Models\Plans;
use App\Models\PlanFeatures;

class PlanRepository implements PlanInterface
{
    public function planList(){
        $plan = Plans::with('planFeatures')->get();        
        if($plan){
            return sendResponse(true,200,'Plans List',$plan);
        }
        return sendResponse(false,404, 'something went wrong',[]);
    }

    public function getPlan($id){
        $plan = Plans::find($id);
        if($plan){
            return sendResponse(true,200,'Get Plan',$plan);
        }
        return sendResponse(false,404, 'something went wrong',[]);
    }

    public function planCreateOrUpdate($request){
        if($request->id){
            $plan = Plans::find($request->id);
            $plan->update([
                'broker_id' => $request->broker_id,
                'plan_name' => $request->plan_name,
                'plan_details' => $request->plan_details,
                'plan_price' => $request->plan_price,
                'plan_duration' => $request->plan_duration,
                'is_plan_free_trial' => $request->is_plan_free_trial,  
            ]);
            $msg = 'Plan update successfully';
        }else{
            $plan =  Plans::create([
                'broker_id' => $request->broker_id,
                'plan_name' => $request->plan_name,
                'plan_details' => $request->plan_details,
                'plan_price' => $request->plan_price,
                'plan_duration' => $request->plan_duration,
                'is_plan_free_trial' => $request->is_plan_free_trial,
            ]);
            $msg = 'Plan save successfully';
        }
        if($plan){
            return sendResponse(true,200,$msg,$plan);
        }
        return sendResponse(false,404, 'something went wrong',[]);
    }

    public function planDelete($id){
        $plan = Plans::find($id);
        if($plan->delete()){
            return sendResponse(true,200,'Plan Deleted successfully',[]);
        }
        return sendResponse(false,404, 'something went wrong',[]);
    }

    public function planFeaturesList(){
        $planFeatures = PlanFeatures::all();
        if($planFeatures){
            return sendResponse(true,200,'Plan Features List',$planFeatures);
        }
        return sendResponse(false,404, 'something went wrong',[]);
    }

    public function getPlanFeatures($id){
        $plan = PlanFeatures::find($id);
        if($plan){
            return sendResponse(true,200,'Get Plan Features',$plan);
        }
        return sendResponse(false,404, 'something went wrong',[]);
    }

    public function planFeaturesCreateOrUpdate($request){
        if($request->id){
            $planFeatures = PlanFeatures::find($request->id);
            $planFeatures->update([
                'plan_id' => $request->plan_id,
                'plan_feature' => $request->plan_feature,
            ]);
            $msg = 'Plan Features update successfully';
        }else{
            $planFeatures =  PlanFeatures::create([
                'plan_id' => $request->plan_id,
                'plan_feature' => $request->plan_feature,
            ]);
            $msg = 'Plan Features save successfully';
        }
        if($planFeatures){
            return sendResponse(true,200,$msg,$planFeatures);
        }
        return sendResponse(false,404, 'something went wrong',[]);
    }

    public function planFeaturesDelete($id){
        $planFeatures = PlanFeatures::find($id);
        if($planFeatures->delete()){
            return sendResponse(true,200,'Plan Features Deleted successfully',[]);
        }
        return sendResponse(false,404, 'something went wrong',[]);
    }
}