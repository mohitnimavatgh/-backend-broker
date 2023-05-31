<?php

namespace App\Repositories\Broker;

use App\Interfaces\Broker\BrokerAuthInterface as BrokerAuthInterface;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\UserDetails;
use Twilio\Rest\Client;


class BrokerAuthRepository implements BrokerAuthInterface
{
    public $user;

    function __construct(User $user) {
	    $this->user = $user;
    }

    public function brokerRigster($request)
    {          
        $sendOtp = sendOTP($request->mobile_no);
        if($sendOtp){
            $user = User::create([      
                'mobile_no' => $request->mobile_no,          
                'role_name' => 'broker',          
            ]);
            User::where('mobile_no',$request->mobile_no)->update(['verified_otp' => $sendOtp]);
            if($user){  
                $user['otp'] = $sendOtp;
            }
           return sendResponse(true,200,'Register successfully',$user);

        }else{
            return sendResponse(false,404,'something went wrong',[]);
        }
    }

    public function brokerVerification($request)
    {
        $user =  User::where('mobile_no',$request->mobile_no)->first(['id','verified_otp','mobile_no']);       
        if($user->verified_otp == $request->otp){
           User::where('mobile_no',$request->mobile_no)->update(['mobile_verified_at' => 1]);
           return sendResponse(true,200,'verification successfully',$user);
        } 
        return sendResponse(false,422, 'Invalid OTP Code',[]);
    }

    public function brokerDetails($request)
    {
        $user = User::find($request->user_id);
        
        if ($request->has('photo')) {                                                
            if($user->photo != NULL && Storage::exists($user->photo)){
                Storage::delete($user->photo);
            }
            $photo_file = $request->file('photo');
            $filename = uniqid('photo_').time().'.'.$photo_file->getClientOriginalExtension();
            $file_path = $request->file('photo')->storeAs('/public/images/broker',$filename);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->address = $request->address;
        $user->photo = $file_path;
        $user->save();
        if($user){
            return sendResponse(true,200, 'Details save successfully.',$user);
        }else{
            return sendResponse(false,404, 'something went wrong',[]);
        }
    }

    public function brokerCertificatedDetailsForWork($request)
    {
        $getuserDetails = UserDetails::where('user_id',$request->user_id)->first();       
        $file_path = '';
        if ($request->has('certificate_photo')) {     
            if($getuserDetails->certificate_photo != NULL && Storage::exists($getuserDetails->certificate_photo)){
                Storage::delete($getuserDetails->certificate_photo);
            }
            $photo_file = $request->file('certificate_photo');
            $filename = uniqid('certificate_photo_').time().'.'.$photo_file->getClientOriginalExtension();
            $file_path = $request->file('certificate_photo')->storeAs('/public/images/user/certificateDoc',$filename);
        }
        
        if(!$getuserDetails){
            $userDetails = UserDetails::create([      
                'user_id' => $request->user_id,          
                'title' => $request->title,     
                'description' => $request->description,     
                'start_date' => $request->start_date,     
                'end_date' => $request->end_date,     
                'certificate_photo' => isset($file_path)?$file_path:NULL,     
            ]);           
        }else{
            $getuserDetails->title = $request->title;     
            $getuserDetails->description = $request->description;    
            $getuserDetails->start_date = $request->start_date;   
            $getuserDetails-> end_date = $request->end_date;  
            $getuserDetails->certificate_photo = isset($file_path)?$file_path:$getuserDetails->certificate_photo;  
            $getuserDetails->save();
            $userDetails = $getuserDetails;
        }

        if($userDetails){
            return sendResponse(true,200,'success',$userDetails);
        }else{
            return sendResponse(false,404, 'something went wrong',[]);
        }
    }

    public function brokerGetLoginPin($request)
    {
        $user = User::where('id',$request->user_id)
                  ->update(['password' => Hash::make($request->password),
                            'visible_password' => $request->password]);
        if($user){
            return sendResponse(true,200,'success',[]);
        }else{
            return sendResponse(false,404, 'something went wrong',[]);
        }
    }

    public function brokerlogin($request)
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
        }else{
            return sendResponse(false,404, 'something went wrong',[]);
        }
    }

    public function brokerPasswordForgot($request){
        $sendOtp = sendOTP($request->mobile_no);
        if($sendOtp){
           User::where('mobile_no',$request->mobile_no)->update(['verified_otp' => $sendOtp]);
           $user['otp'] = $sendOtp;
           return sendResponse(true,200,'send OTP successfully',$user);
        }else{
            return sendResponse(false,404,'something went wrong',[]);
        }
    }

    public function brokerChangePassword($request){      
        $user=User::where(['id'=>$request->user_id])->first();
        if(Hash::check($request->old_password, $user->password) && $user != ''){
            $user->password=Hash::make($request->new_password);
            $user->visible_password=$request->new_password;
            $user->save();    
            return sendResponse(true,200,'password change SuccessFully',$user);
        }else{
            return sendResponse(false,404, ["currentpassword"=>['current password not match.']],[]);
        }
    }
}