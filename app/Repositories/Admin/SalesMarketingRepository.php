<?php

namespace App\Repositories\Admin;

use App\Interfaces\Admin\SalesMarketingInterfaces;
use App\Models\User; 
use Illuminate\Support\Facades\Hash;

class SalesMarketingRepository implements SalesMarketingInterfaces
{ 
    public function add($input)
    { 
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