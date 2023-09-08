<?php

namespace App\Http\Controllers\Api\Broker\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Broker\CreateBrokerRequest;
use App\Http\Requests\Broker\CertificatedDetailsForWorkRequest;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Interfaces\Broker\BrokerAuthInterface;
use Validator;

class BrokerAuthController extends BaseController
{
    public function __construct(BrokerAuthInterface $brokerAuthRepository)
    {
        $this->brokerAuth = $brokerAuthRepository;
    }

    //  creating a new broker user.
    public function brokerRigster(Request $request)
    {
       try {
            $validator = Validator::make($request->all(),
            ['mobile_no' => 'required|numeric|digits:10']);

            if ($validator->fails())
            {
                return response()
                    ->json(['status' => false,'status_code' => 422, 'message' => $validator->errors() ], 422);
            }    
            return $this->brokerAuth->brokerRigster($request);
       }catch (\Exception $e) {
            return $this->sendError($e, $e->getMessage() , $e->getCode());
       }
    }

    // creating a new broker user Verification function.
    public function brokerVerification(Request $request)
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
            return $this->brokerAuth->brokerVerification($request);
        }catch (\Exception $e) {
            return $this->sendError($e, $e->getMessage() , $e->getCode());
        }
    }

    // Get Details of broker user 
    public function brokerDetails(CreateBrokerRequest $request)
    {        
        try { 
            return $this->brokerAuth->brokerDetails($request);
        }catch (\Exception $e) {
            return $this->sendError($e, $e->getMessage() , $e->getCode());
        }
    }

    // Get Certificated details of Boker's work
    public function brokerCertificatedDetailsForWork(CertificatedDetailsForWorkRequest $request)
    {
        try { 
            return $this->brokerAuth->brokerCertificatedDetailsForWork($request);        
        }catch (\Exception $e) {
            return $this->sendError($e, $e->getMessage() , $e->getCode());
        }
    }

    // Get login Pin of broker user
    public function brokerGetLoginPin(Request $request)
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
            return $this->brokerAuth->brokerGetLoginPin($request);                   
        }catch (\Exception $e) {
            return $this->sendError($e, $e->getMessage() , $e->getCode());
        }
    }

    // login function of broker user
    public function brokerlogin(Request $request)
    {
        $validator = Validator::make($request->all() ,['email' => 'required|email', 'password' => 'required|digits:6']);

        if ($validator->fails())
        {
            return response()->json(['status' => false, 'status_code' => 422, 'message' => $validator->errors() ], 422);
        } 
        return $this->brokerAuth->brokerlogin($request);
    }

    //  password forgot for broker user
    public function brokerPasswordForgot(Request $request)
    {
       try {
            $validator = Validator::make($request->all(),
            ['mobile_no' => 'required|numeric|digits:10|exists:users']);

            if ($validator->fails())
            {
                return response()
                    ->json(['status' => false,'status_code' => 422, 'message' => $validator->errors() ], 422);
            }    
            return $this->brokerAuth->brokerPasswordForgot($request);

       }catch (\Exception $e) {
            return $this->sendError($e, $e->getMessage() , $e->getCode());
       }
    }

    //  change password for broker user
    public function brokerChangePassword(Request $request)
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
             return $this->brokerAuth->brokerChangePassword($request);
 
        }catch (\Exception $e) {
             return $this->sendError($e, $e->getMessage() , $e->getCode());
        }
    }
}
