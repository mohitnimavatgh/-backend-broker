<?php

namespace App\Repositories\Admin;

use App\Interfaces\Admin\SalesMarketingInterface;
use App\Models\User;  
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class SalesMarketingRepository implements SalesMarketingInterface
{ 
    public $user;
    function __construct(User $user) {
	    $this->user = $user;
    }

    public function list($request)
    { 
        $salesMarketing = [];
        if($request->user_id){ 
            $salesMarketing = User::where('id',$request->user_id)->where('role_name','sales and marketing')->first();
        }else{
           $salesMarketing = User::where('role_name','sales and marketing')->select(['id','name','email','mobile_no','address','photo'])->paginate(10);
        }        
        return sendResponse(true,200,'Sales & Marketing users list',$salesMarketing);        
    }

    public function add($request)
    { 
         
        $salesMarketing =  User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'visible_password' => $request->password,
            'role_name' => 'sales and marketing',
        ]);
        if($salesMarketing){
            $data = 'sales and marketing';
            $email =  $request->email;
            $status = mailsend($email,$data);
            return sendResponse(true,200,'Sales & Marketing user add successfully',$salesMarketing);
        }
        return sendResponse(false,404, 'something went wrong',[]);
    }

    public function edit($request)
    {
        $salesMarketing = User::find($request->id);
        $updateUser =  $salesMarketing->update([
            'name' => isset($request->name) ? $request->name : $user->name,
            'email' => isset($request->email) ? $request->email : $user->email,  
        ]);
        if($updateUser){
            return sendResponse(true,200,'Sales & Marketing user update successfully',$salesMarketing);
        }
        return sendResponse(false,404, 'something went wrong',[]);
    }

    public function delete($id)
    {
        $user = User::find($id);
        if($user->delete($id)){
            return sendResponse(true,200,'Sales & Marketing user delete successfully',[]);
        }
        return sendResponse(false,404, 'something went wrong',[]);
    }

    public function passwordForgotForSendMail($request){
        $otp = rand(100000,999999);
        $data = 'sales and marketing User verify OTP :'.$otp;
        $email =  $request->email;
        $status = mailsend($email,$data);
        if($status){
            User::where('email',$request->email)->update(['verified_otp' => $otp]);
            return sendResponse(true,200,'Mail Send successfully',[]);
        }
        return sendResponse(false,404, 'something went wrong',[]);
    }

    public function userVerification($request)
    {
        $user =  User::where('email',$request->email)->first();       
        if($user->verified_otp == $request->otp){
           User::where('email',$request->email)->update(['email_verified_at' => 1]);
           return sendResponse(true,200,'verification successfully',$user);
        } 
        return sendResponse(false,422, 'Invalid OTP Code',[]);
    }

    public function passwordForgotSet($request){
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