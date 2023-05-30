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

    public function brokerRigster(Request $request)
    {
       try {
            $validator = Validator::make($request->all(),
            ['mobile_no' => 'required|numeric|digits:10|unique:users']);

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

    public function brokerDetails(CreateBrokerRequest $request)
    {        
        try { 
            return $this->brokerAuth->brokerDetails($request);
        }catch (\Exception $e) {
            return $this->sendError($e, $e->getMessage() , $e->getCode());
        }
    }

    public function brokerCertificatedDetailsForWork(CertificatedDetailsForWorkRequest $request)
    {
        try { 
            return $this->brokerAuth->brokerCertificatedDetailsForWork($request);        
        }catch (\Exception $e) {
            return $this->sendError($e, $e->getMessage() , $e->getCode());
        }
    }

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

    public function brokerlogin(Request $request)
    {
        $validator = Validator::make($request->all() ,['email' => 'required', 'password' => 'required']);

        if ($validator->fails())
        {
            return response()->json(['status' => false, 'status_code' => 422, 'message' => $validator->errors() ], 422);
        } 

        return $this->brokerAuth->brokerlogin($request);
    }
}
