<?php

namespace App\Repositories\Admin;

use App\Interfaces\Admin\SalesMarketingInterfaces;
use App\Models\User;  
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class SalesMarketingRepository implements SalesMarketingInterfaces
{ 
    public function list()
    { 
        return User::where('role_name', 'sales and marketing')->select('id','name','email','mobile_no','address','photo','created_at')->paginate(10);
    }
    public function add($input)
    { 
        Mail::send(['text'=>'mail'], $input, function($message) use ($input) {
            $message->to($input->email)->subject
               ('sales and marketing');
            $message->from(env('MAIL_FROM_ADDRESS'));
         });
        return User::create([
            'name' => $input->name,
            'email' => $input->email,
            'password' => Hash::make($input->password),
            'role_name' => 'sales and marketing',
        ]);
    }


    public function edit($input)
    {
        $user = User::find($input->id);
        return $user->update([
            'name' => isset($input->name) ? $input->name : $user->name,
            'email' => isset($input->email) ? $input->email : $user->email,  
        ]);
    }


    public function delete($id)
    {
        $user = User::find($id);
        return $user->delete($id);
    }
}