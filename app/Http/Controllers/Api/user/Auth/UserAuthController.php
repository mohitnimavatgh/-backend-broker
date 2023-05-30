<?php

namespace App\Http\Controllers\Api\User\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Http\Requests\User\CreateUserRequest;
use App\Interfaces\User\UserAuthInterface;
use Illuminate\Http\Request;
use Validator;

class UserAuthController extends BaseController
{
    public function __construct(UserAuthInterface $userAuthRepository)
    {
        $this->userAuth = $userAuthRepository;
    }

    public function userRigster(Request $request)
    {
       try {
            $validator = Validator::make($request->all(),['mobile_no' => 'required|numeric|digits:10|unique:users']);

            if ($validator->fails())
            {
                return response()
                    ->json(['status' => false,'status_code' => 422, 'message' => $validator->errors() ], 422);
            }
            
            return $this->userAuth->userRigster($request);

       }catch (\Exception $e) {
            return $this->sendError($e, $e->getMessage() , $e->getCode());
       }
    }

    public function userVerification(Request $request)
    {
        try {     
            
            $validator = Validator::make($request->all(),[
                'mobile_no' => 'required|numeric|digits:10',                
                'otp' => 'required|numeric|digits:6',                
            ]);

            if ($validator->fails())
            {
                return response()
                    ->json(['status' => false,'status_code' => 422, 'message' => $validator->errors() ], 422);
            }

            return $this->userAuth->userVerification($request);       
        
        }catch (\Exception $e) {
            return $this->sendError($e, $e->getMessage() , $e->getCode());
        }
    }

    public function userDetails(CreateUserRequest $request)
    {
        try { 
            $data = $this->userAuth->userDetails($request);        
            return $data;
        }catch (\Exception $e) {
            return $this->sendError($e, $e->getMessage() , $e->getCode());
        }
    }

    public function userGetLoginPin(Request $request)
    {
        try { 
            $validator = Validator::make($request->all(),[
                'password' => 'required|digits:6|unique:users', 
                'user_id'  => 'required'               
            ]);

            if ($validator->fails())
            {
                return response()
                    ->json(['status' => false,'status_code' => 422, 'message' => $validator->errors() ], 422);
            }

            return $this->userAuth->userGetLoginPin($request);                   

        }catch (\Exception $e) {
            return $this->sendError($e, $e->getMessage() , $e->getCode());
        }
    }

    public function userlogin(Request $request)
    {
        $validator = Validator::make($request->all() ,['email' => 'required|email', 'password' => 'required|digits:6']);

        if ($validator->fails())
        {
            return response()->json(['status' => false, 'status_code' => 422, 'message' => $validator->errors() ], 422);
        } 

        return $this->userAuth->userlogin($request);
    }
}
