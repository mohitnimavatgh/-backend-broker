<?php

namespace App\Repositories\User;

use App\Interfaces\User\UserAuthInterface as UserAuthInterface;
use App\Models\User;
use Twilio\Rest\Client;


class UserAuthRepository implements UserAuthInterface
{
    public $user;

    function __construct(User $user) {
	$this->user = $user;
    }

    public function userRigster($request)
    {
  
        $user = User::create([      
            'mobile_no' => $request->mobile_no,          
        ]);
        
        $sendOtp = sendOTP($request->mobile_no);

        if($user){  
            $user['otp'] = $sendOtp;
        }

        return  $user;
    }

   
}