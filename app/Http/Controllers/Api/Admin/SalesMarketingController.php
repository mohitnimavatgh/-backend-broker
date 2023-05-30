<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Interfaces\Admin\SalesMarketingInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SalesMarketingController extends BaseController
{
    public function __construct(SalesMarketingInterface $SalesMarketingRepository)
    {
        $this->SalesMarketingRepository = $SalesMarketingRepository;
    }

    public function list(Request $request){
        return $this->SalesMarketingRepository->list($request);
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

        return $this->SalesMarketingRepository->add($request);
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

        return $this->SalesMarketingRepository->edit($request);
    }

    public function delete($id)
    {
        return $this->SalesMarketingRepository->delete($id);
    }
}
