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
    
        $account_sid = 'AC1646d9cef27b0bbada6df4653eef10a2'; 
        $auth_token = 'ee004cad5df075227cd0fd55b4673ed6';
        $twilio_number = '+13157137042';
        $twilio_verify_sid = 'VAb84e5fd30634edfc0c183f0c14af0bf0';

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