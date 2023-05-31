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

    // get listing of sales
    public function list(Request $request){
        try {
            return $this->SalesMarketingRepository->list($request);
        }catch (\Exception $e) {
            return $this->sendError($e, $e->getMessage() , $e->getCode());
       }
    }

    // create a new sales
    public function add(Request $request)
    {
        try {
            $validator = Validator::make($request->all() ,[
                'email' => 'required|email|unique:users', 
                'name' => 'required', 
                'password' => 'required|numeric|digits:6'
            ]);

            if ($validator->fails())
            {
                return response()->json(['status' => false, 'status_code' => 422, 'message' => $validator->errors() ], 422);
            } 

            return $this->SalesMarketingRepository->add($request);
        }catch (\Exception $e) {
            return $this->sendError($e, $e->getMessage() , $e->getCode());
       }
    }

    // edit function of sales
    public function edit(Request $request)
    {
        try {
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
        }catch (\Exception $e) {
            return $this->sendError($e, $e->getMessage() , $e->getCode());
       }
    }

    // delete function of sales
    public function delete($id)
    {
        try {
            return $this->SalesMarketingRepository->delete($id);
        }catch (\Exception $e) {
            return $this->sendError($e, $e->getMessage() , $e->getCode());
       }
    }

    // password Forgot For Send Mail
    public function passwordForgotForSendMail(Request $request)
    {
       try {
            $validator = Validator::make($request->all(),
            ['email' => 'required|email|exists:users']);

            if ($validator->fails())
            {
                return response()
                    ->json(['status' => false,'status_code' => 422, 'message' => $validator->errors() ], 422);
            }    

            return $this->SalesMarketingRepository->passwordForgotForSendMail($request);

       }catch (\Exception $e) {
            return $this->sendError($e, $e->getMessage() , $e->getCode());
       }
    }

     // creating a new User Verification function.   
     public function userVerification(Request $request)
     {
         try {     
             
             $validator = Validator::make($request->all(),[
                 'email' => 'required|email|exists:users',                
                 'otp' => 'required|numeric|digits:6',                
             ]);
 
             if ($validator->fails())
             {
                 return response()
                     ->json(['status' => false,'status_code' => 422, 'message' => $validator->errors() ], 422);
             }
 
             return $this->SalesMarketingRepository->userVerification($request);       
         
         }catch (\Exception $e) {
             return $this->sendError($e, $e->getMessage() , $e->getCode());
         }
     }

    public function passwordForgotSet(Request $request)
    {
        try {
            $validator = Validator::make($request->all(),
            [
               'user_id' => 'required|numeric',
               'old_password' => 'required|numeric|digits:6',
               'new_password' => 'required|digits:6|different:old_password',
               'confirmpassword'=>'required|same:new_password'
            ]);

            if ($validator->fails())
            {
                return response()
                    ->json(['status' => false,'status_code' => 422, 'message' => $validator->errors() ], 422);
            }    
            return $this->SalesMarketingRepository->passwordForgotSet($request);

       }catch (\Exception $e) {
            return $this->sendError($e, $e->getMessage() , $e->getCode());
       }
    }
}
