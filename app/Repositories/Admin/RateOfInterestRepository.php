<?php

namespace App\Repositories\Admin;

use App\Interfaces\Admin\RateOfInterestInterface as RateOfInterestInterface;
use App\Models\RateOfInterests;

class RateOfInterestRepository implements RateOfInterestInterface
{ 
    public function RateOfInterestsCreate($request)
    { 
        $rateOfInterestsAdd =  RateOfInterests::create([
            'rate_of_interest' => $request->rate_of_interest,
        ]);
        if($rateOfInterestsAdd){
            return sendResponse(true,200,'Rate of interest save successfully',$rateOfInterestsAdd);
        }
        return sendResponse(false,404, 'something went wrong',[]);
    }

    public function RateOfInterestsUpdate($request)
    { 
        $rateOfInterests = RateOfInterests::find($request->id);
        $rateOfInterests->update([
            'rate_of_interest' => $request->rate_of_interest,

        ]);
        if($rateOfInterests){
            return sendResponse(true,200,'Rate of interest update successfully',$rateOfInterests);
        }
        return sendResponse(false,404, 'something went wrong',[]);
    }

    public function RateOfInterestsDelete($request)
    { 
        $rateOfInterests = RateOfInterests::find($request->id);
        $rateOfInterests->delete();
        if($rateOfInterests){
            return sendResponse(true,200,'Rate of interest Deleted successfully',[]);
        }
        return sendResponse(false,404, 'something went wrong',[]);
    }

    public function RateOfInterestsList($request)
    { 
        if($request->id){
            $rateOfInterestsData = RateOfInterests::where('id',$request->id)->get();
        }else{
            $rateOfInterestsData = RateOfInterests::all();
        }
        return sendResponse(true,200,'Rate of interest List',$rateOfInterestsData);
    }
}