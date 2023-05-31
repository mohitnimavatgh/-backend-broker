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
   
    // creating a new User.   
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

    // creating a new User Verification function.   
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

    // Get User Details
    public function userDetails(CreateUserRequest $request)
    {
        try { 
            $data = $this->userAuth->userDetails($request);        
            return $data;
        }catch (\Exception $e) {
            return $this->sendError($e, $e->getMessage() , $e->getCode());
        }
    }

    // Get login Pin of user
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

    // login function of user
    public function userlogin(Request $request)
    {
        $validator = Validator::make($request->all() ,['email' => 'required|email', 'password' => 'required|digits:6']);

        if ($validator->fails())
        {
            return response()->json(['status' => false, 'status_code' => 422, 'message' => $validator->errors() ], 422);
        } 

        return $this->userAuth->userlogin($request);
    }

    //  password forgot for broker user
    public function userPasswordForgot(Request $request)
    {
        try {
             $validator = Validator::make($request->all(),
             ['mobile_no' => 'required|numeric|digits:10|exists:users']);
 
             if ($validator->fails())
             {
                 return response()
                     ->json(['status' => false,'status_code' => 422, 'message' => $validator->errors() ], 422);
             }    
 
             return $this->userAuth->userPasswordForgot($request);
 
        }catch (\Exception $e) {
             return $this->sendError($e, $e->getMessage() , $e->getCode());
        }
    }

    //  change password for user
    public function userChangePassword(Request $request)
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
             return $this->userAuth->userChangePassword($request);
 
        }catch (\Exception $e) {
             return $this->sendError($e, $e->getMessage() , $e->getCode());
        }
    }
}
