<?php

namespace App\Repositories\Admin;

use App\Interfaces\Admin\AdminAuthInterface as AdminAuthInterface;
use App\Models\User;


class AdminAuthRepository implements AdminAuthInterface
{
    public $user;


    function __construct(User $user) {
	    $this->user = $user;
    }

    public function adminlogin($request)
    {
        $fieldType = filter_var($request->email, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        if (!auth()
            ->attempt(array(
            $fieldType => $request->email,
            'password' => $request->password,
            'role_name' => $request->role_name,
            )))
        {
            return sendResponse(false,400,'Invalid Credentials',[]);
        }

        // if(!auth()->user()->email_verified_at){
        //     Auth::logout();
        //     return $this->sendResponse(false, 'message' => 'please verify your email address !'], 400);
        // }

        $accessToken = auth()->user()
            ->createToken('authToken')->accessToken;
        $user = auth()->user(); 
        $user['access_token'] = $accessToken; 
       
        if($user){
            return sendResponse(true, 200,'Login successfully',$user);
        }else{
            return sendResponse(false,404, 'something went wrong',[]);
        }
    }   
}