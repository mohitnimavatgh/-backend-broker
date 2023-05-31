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
}
