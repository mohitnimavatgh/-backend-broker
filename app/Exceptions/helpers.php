<?php 
use Twilio\Rest\Client;

function mailsend($email=null,$data=null){
    try {

        Mail::send('auth.emails.emailVerificationEmail', ['data' => $data], function($message) use($email){
            $message->to($email);
            $message->subject('Email Verification Mail');
        });
        
        return true;

      } catch (\Exception $e) {      
          return $e->getMessage();
      }
    
}

function sendOTP($no){
    try {

        $otp = rand(100000,999999);
        $receiverNumber = '+91'.$no;
        $message = "Your OTP verification code is: ".$otp;    
    
        $account_sid = env('TWILIO_ACCOUNT_SID'); 
        $auth_token = env('TWILIO_AUTH_TOKEN');
        $twilio_number = env('TWILIO_NUMBER');
        $twilio_verify_sid = env('TWILIO_VERIFY_SID');

        $client = new Client($account_sid, $auth_token);
        $client->messages->create($receiverNumber, [
                'from' => $twilio_number, 
                'body' => $message]);

       return $otp;

    } catch (Exception $e) {
        return false;
    }
}

function sendResponse($status,$status_code,$message,$result)
{ 
    $response = [
        'status' => $status,
        'status_code' =>  $status_code,
        'message' => $message,
        'data'    => $result,
    ];
    return response()->json($response,$status_code);
}

?>