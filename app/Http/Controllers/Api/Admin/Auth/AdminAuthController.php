<?php

namespace App\Http\Controllers\Api\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Interfaces\Admin\AdminAuthInterface;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class AdminAuthController extends Controller
{
    public function __construct(AdminAuthInterface $AdminAuthInterface)
    {
        $this->adminAuth = $AdminAuthInterface;
    }

    // login function of admin
    public function adminlogin(Request $request){
        try {
            $validator = Validator::make($request->all() ,['email' => 'required|email', 'password' => 'required|digits:6']);

            if ($validator->fails())
            {
                return response()->json(['status' => false, 'status_code' => 422, 'message' => $validator->errors() ], 422);
            } 
            return $this->adminAuth->adminlogin($request);
        }catch (\Exception $e) {
            return $this->sendError($e, $e->getMessage() , $e->getCode());
       }
    }

    public function adminChangePassword(Request $request){
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
            return $this->adminAuth->adminChangePassword($request);

       }catch (\Exception $e) {
            return $this->sendError($e, $e->getMessage() , $e->getCode());
       }
    }
}
