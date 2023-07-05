<?php

namespace App\Repositories\Admin;

use App\Interfaces\Admin\AdminInterface as AdminInterface;
use App\Models\User;


class AdminRepository implements AdminInterface
{
    public function getUserList($request)
    {
        if($request->role == 'user'){
            $getUserAll = User::select(['id','name','role_name','email','mobile_no','address'])->where('role_name',$request->role)->paginate(5);
        }elseif($request->role == 'broker'){
            $getUserAll = User::select(['id','name','role_name','email','mobile_no','address'])->where('role_name',$request->role)->paginate(5);
        }elseif($request->role == 'sales and marketing'){
            $getUserAll = User::select(['id','name','role_name','email'])->where('role_name',$request->role)->paginate(5);
        }else{
            $getUserAll = User::select(['id','name','role_name','email','mobile_no','address'])->where('role_name','!=','admin')->paginate(5);
        }
        if($getUserAll){
            return sendResponse(true, 200,'get user successfully',$getUserAll);
        }
        return sendResponse(false,404, 'something went wrong',[]);
    }
}