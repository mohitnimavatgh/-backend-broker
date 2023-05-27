<?php

namespace App\Http\Controllers\Api\user\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Interfaces\User\UserAuthInterface;
use Illuminate\Http\Request;
use Validator;
use App\Http\Requests\CreateUserRequest;

class UserAuthController extends BaseController
{
    public function __construct(UserAuthInterface $userAuthRepository)
    {
        $this->userAuth = $userAuthRepository;
    }

    public function userRigster(Request $request)
    {
       try {
            $rules=[
                'mobile_no' => 'required|numeric|digits:10|unique:users',                
            ];

            $validator = Validator::make($request->all(),$rules);

            if ($validator->fails())
            {
                return response()
                    ->json(['status' => false,'status_code' => 422, 'message' => $validator->errors() ], 422);
            }
            
            $data = $this->userAuth->userRigster($request);

            return $this->sendResponse($data, 'Register successfully.');

       }catch (\Exception $e) {
            return $this->sendError($e, $e->getMessage() , $e->getCode());
       }
    }
}
