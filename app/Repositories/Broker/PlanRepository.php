<?php 

namespace App\Repositories\Broker;
use App\Interfaces\Broker\PlanInterface as PlanInterface;
use App\Repositories\Payment\StripePaymentRepository;
use App\Models\UserDetails;
use App\Models\Plans;
use DB;
use App\Models\PlanFeatures;

class PlanRepository implements PlanInterface
{
    public function allPlanLists($request){
        $query = Plans::where('id','!=',0);       
        if($request->search){
            $searchValue = $request->search;
            $query->where(function ($query1) use ($searchValue) {
                $query1->where('plan_name', 'LIKE', '%' . $searchValue . '%')
                    ->orWhere('plan_duration', 'LIKE', '%' . $searchValue . '%')
                    ->orWhere('plan_price', '=', $searchValue);
            });
            $query->orderBy('id','asc');
        }
        if($request->sortPlanDuration){
            $query->where('plan_duration','LIKE','%'.$request->sortPlanDuration.'%');
        }
        if($request->sortPlanPrice){
            $query->orderBy('plan_price',$request->sortPlanPrice);
        }
        $plan = $query->with('planFeatures')->paginate(6);
        return sendResponse(true,200,'All Plans List',$plan);
    }

    public function planList($request){
        if($request->id){
            $query = Plans::where('broker_id', $request->id);
            if ($request->sortPlanPrice) {
                $query->orderBy('plan_price', $request->sortPlanPrice);
            }
            if ($request->sortData) {
                $query->orderBy('created_at', $request->sortData);
            }
            if ($request->sortPlanDuration) {
                $query->orderBy('plan_duration', $request->sortPlanDuration);
            }
            if(strtoupper($request->item) == 'ALL'){
                $plan = $query->get();
            }else{
                $plan = $query->with('planFeatures','broker')->paginate(10);
            }
        }else{
            $plan = Plans::with('planFeatures','broker')->paginate(10);
        }
        if($plan){
            return sendResponse(true,200,'Plans List',$plan);
        }
        return sendResponse(false,404, 'something went wrong',[]);
    }

    public function getPlan($id){
        $plan = Plans::find($id);
        return sendResponse(true,200,'Get Plan',$plan);
    }

    public function planCreate($request){
        
        $plan =  Plans::create([
            'broker_id' => $request->broker_id,
            'plan_name' => $request->plan_name,
            'plan_details' => $request->plan_details,
            'plan_price' => $request->plan_price,
            'plan_duration' => $request->plan_duration,
            'is_plan_free_trial' => $request->is_plan_free_trial,
        ]);

        // $stripePaymentRepository = app(StripePaymentRepository::class);
        // $response =  $stripePaymentRepository->stripeAddPlan($request);
        // $resp = $response->getData();   
        // $plan->update([
        //     'stripe_plan_id' => $resp->data->product->id,
        //     'stripe_plan_price_id' => $resp->data->prices->id
        // ]);

        if($plan){
            return sendResponse(true,200,'Plan save successfully',$plan);
        }
        return sendResponse(false,404, 'something went wrong',[]);
    }

    public function planUpdate($request){
        $plan = Plans::find($request->id);
        $plan->update([
            'broker_id' => $request->broker_id,
            'plan_name' => $request->plan_name,
            'plan_details' => $request->plan_details,
            'plan_price' => $request->plan_price,
            'plan_duration' => $request->plan_duration,
            'is_plan_free_trial' => $request->is_plan_free_trial,  
        ]);
        if($plan){
            return sendResponse(true,200,'Plan update successfully',$plan);
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

    public function planFeaturesList($request){
        $planFeatures = [];
        if(isset($request->broker_id)){
            $planFeatures = PlanFeatures::join('plans', 'plan_features.plan_id', '=', 'plans.id')
                            ->where('plans.broker_id', $request->broker_id)
                            ->select('plan_features.*')
                            ->with(['plan:id,plan_name'])
                            ->paginate(10);
        }elseif (isset($request->plan_id)) {
            $planFeatures = PlanFeatures::where('plan_id',$request->plan_id)->with(['plan:id,plan_name'])->paginate(10);
        }else{
            $planFeatures = PlanFeatures::with(['plan:id,plan_name'])->paginate(10);
        }
        return sendResponse(true,200,'Plan Features List',$planFeatures);
    }

    public function getPlanFeatures($request){
        $plan = PlanFeatures::find($request->id);       
        return sendResponse(true,200,'Get Plan Features',$plan);
    }

    public function planFeaturesCreate($request){
        $planFeatures =  PlanFeatures::create([
            'plan_id' => $request->plan_id,
            'plan_feature' => $request->plan_feature,
        ]);
        if($planFeatures){
            return sendResponse(true,200,'Plan Features save successfully',$planFeatures);
        }
        return sendResponse(false,404, 'something went wrong',[]);
    }

    public function planFeaturesUpdate($request){
        $planFeatures = PlanFeatures::find($request->id);
        $planFeatures->update([
            'plan_id' => $request->plan_id,
            'plan_feature' => $request->plan_feature,
        ]);
        if($planFeatures){
            return sendResponse(true,200,'Plan Features update successfully',$planFeatures);
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