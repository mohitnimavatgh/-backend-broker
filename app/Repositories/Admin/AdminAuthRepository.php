<?php

namespace App\Repositories\Admin;

use App\Interfaces\Admin\AdminAuthInterface as AdminAuthInterface;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

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
            return sendResponse(false,401,'Invalid Credentials',[]);
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
        }
        return sendResponse(false,404, 'something went wrong',[]);
    }

    public function adminChangePassword($request){      
        $user=User::where(['id'=>$request->user_id])->first();
        if(Hash::check($request->old_password, $user->password) && $user != ''){
            $user->password=Hash::make($request->new_password);
            $user->visible_password=$request->new_password;
            $user->save();    
            return sendResponse(true,200,'password change SuccessFully',$user);
        }
        return sendResponse(false,404, ["currentpassword"=>['current password not match.']],[]);
    }
}