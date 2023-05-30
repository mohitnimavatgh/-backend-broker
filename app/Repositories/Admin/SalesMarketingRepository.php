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
        if($request->id){
            $salesMarketing = User::where('role_name', 'sales and marketing')->where('id',$request->id)->select('id','name','email','mobile_no','address','photo')->paginate(10);
        }else{
            $salesMarketing = User::where('role_name', 'sales and marketing')->select('id','name','email','mobile_no','address','photo')->paginate(10);
        }
        if($salesMarketing){
            return sendResponse(true,200,'Sales & Marketing users list',$salesMarketing);
        }else{
            return sendResponse(false,404, 'Data Not Found',$salesMarketing);
        }
    }

    public function add($request)
    { 
         
        $salesMarketing =  User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_name' => 'sales and marketing',
        ]);
        if($salesMarketing){
            $data = 'sales and marketing';
            $email =  $request->email;
            $status = mailsend($email,$data);
            return sendResponse(true,200,'Sales & Marketing user add successfully',[]);
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
            return sendResponse(true,200,'Sales & Marketing user update successfully',$updateUser);
        }
        return sendResponse(false,404, 'something went wrong',[]);
    }


    public function delete($id)
    {
        $user = User::find($id);
        if($user->delete($id)){
            return sendResponse(true,200,'Sales & Marketing user delete successfully',[]);
        }else{
            return sendResponse(false,404, 'something went wrong',[]);
        }
    }
}