<?php

namespace App\Repositories\Admin;

use App\Interfaces\Admin\RateOfInterestInterface as RateOfInterestInterface;
use App\Models\RateOfInterests;

class RateOfInterestRepository implements RateOfInterestInterface
{ 
    public function RateOfInterestsCreateOrUpdate($request)
    { 
        if($request->id){
            $rateOfInterests = RateOfInterests::find($request->id);
            $rateOfInterests->update([
                'rate_of_interest' => $request->rate_of_interest,
            ]);
            $msg = 'Rate of interest update successfully';
        }else{
            $rateOfInterests =  RateOfInterests::create([
                'rate_of_interest' => $request->rate_of_interest,
            ]);
            $msg = 'Rate of interest save successfully';
        }
        if($rateOfInterests){
            return sendResponse(true,200,$msg,$rateOfInterests);
        }
        return sendResponse(false,404, 'something went wrong',[]);
    }
}