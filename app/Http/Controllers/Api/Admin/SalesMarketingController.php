<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Interfaces\Admin\SalesMarketingInterfaces;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SalesMarketingController extends BaseController
{
    public function __construct(SalesMarketingInterfaces $SalesMarketingRepository)
    {
        $this->SalesMarketingRepository = $SalesMarketingRepository;
    }

    public function add(Request $request)
    {
        $validator = Validator::make($request->all() ,[
            'email' => 'required|email|unique:users', 
            'name' => 'required', 
            'password' => 'required'
        ]);

        if ($validator->fails())
        {
            return response()->json(['status' => false, 'status_code' => 422, 'message' => $validator->errors() ], 422);
        } 

        $data = $this->SalesMarketingRepository->add($request);
        unset($data['created_at']);
        unset($data['updated_at']);
        return $this->sendResponse($data, 'Sales & Marketing user add successfully.');
    }
    public function delete($id)
    {
          $this->SalesMarketingRepository->delete($id);
          return $this->sendResponse([], 'Sales & Marketing user delete successfully.');
    }
    public function edit(Request $request)
    {
        $validator = Validator::make($request->all() ,[
            'id' => 'required|numeric|exists:users', 
            'email' => 'required|email|unique:users,id,'.$request->id, 
            'name' => 'required', 
        ]);

        if ($validator->fails())
        {
            return response()->json(['status' => false, 'status_code' => 422, 'message' => $validator->errors() ], 422);
        } 

        $this->SalesMarketingRepository->edit($request);
        return $this->sendResponse([], 'Sales & Marketing user update successfully.');
    }
}
