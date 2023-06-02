<?php

namespace App\Repositories\User;

use App\Interfaces\User\UserAuthInterface as UserAuthInterface;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\UserDetails;
use Twilio\Rest\Client;


class UserAuthRepository implements UserAuthInterface
{
    public $user;

    function __construct(User $user) {
	$this->user = $user;
    }

    public function userRigster($request)
    {  
        $sendOtp = sendOTP($request->mobile_no);
        if($sendOtp){
            $user = User::create([      
                'mobile_no' => $request->mobile_no,          
                'role_name' => 'user',          
            ]);
            User::where('mobile_no',$request->mobile_no)->update(['verified_otp' => $sendOtp]);
            if($user){  
                $user['otp'] = $sendOtp;
            }
           return sendResponse(true,200,'Register successfully',$user);
        }
        return sendResponse(false,404,'something went wrong',[]);
    }

    public function userVerification($request)
    {
        $user =  User::where('mobile_no',$request->mobile_no)->first();       
        if($user->verified_otp == $request->otp){
           User::where('mobile_no',$request->mobile_no)->update(['mobile_verified_at' => 1]);
           return sendResponse(true,200,'verification successfully',$user);
        } 
        return sendResponse(false,422, 'Invalid OTP Code',[]);
    }

    public function userDetails($request)
    {
        $user = User::find($request->user_id);
        
        if ($request->has('photo')) {                                                
            if($user->photo != NULL && Storage::exists($user->photo)){
                Storage::delete($user->photo);
            }
            $photo_file = $request->file('photo');
            $filename = uniqid('photo_').time().'.'.$photo_file->getClientOriginalExtension();
            $file_path = $request->file('photo')->storeAs('/public/images/user',$filename);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->address = $request->address;
        $user->photo = $file_path;
        $user->save();
        if($user){
            return sendResponse(true,200, 'Details save successfully.',$user);
        }
        return sendResponse(false,404, 'something went wrong',[]);
    }

    public function userGetLoginPin($request)
    {
        $user = User::where('id',$request->user_id)
                  ->update(['password' => Hash::make($request->password),
                            'visible_password' => $request->password]);
        if($user){
            return sendResponse(true,200,'success',[]);
        }
        return sendResponse(false,404, 'something went wrong',[]);
    }

    public function userlogin($request)
    {   
        $fieldType = filter_var($request->email, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        if (!auth()
            ->attempt(array(
            $fieldType => $request->email,
            'password' => $request->password,
            'role_name' => $request->role_name,
            'mobile_verified_at' => 1,
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
        }
        return sendResponse(false,404, 'something went wrong',[]);
    }

    public function userPasswordForgot($request){
        $sendOtp = sendOTP($request->mobile_no);
        if($sendOtp){
           User::where('mobile_no',$request->mobile_no)->update(['verified_otp' => $sendOtp]);
           $user['otp'] = $sendOtp;
           return sendResponse(true,200,'send OTP successfully',$user);
        }
        return sendResponse(false,404,'something went wrong',[]);
    }

    public function userChangePassword($request){      
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