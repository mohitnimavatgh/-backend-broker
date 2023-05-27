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

        $receiverNumber = '+91'.$no;
        $message = "This is testing from Otp";
    
        // return $no;
    
        $account_sid = 'AC1646d9cef27b0bbada6df4653eef10a2';
        $auth_token = '9e7b677715845d2d6a82d71cb3ce40fe';
        $twilio_number = '+13157137042';
        $twilio_verify_sid = 'VAb84e5fd30634edfc0c183f0c14af0bf0';

        $client = new Client($account_sid, $auth_token);
        $client->verify->v2->services($twilio_verify_sid)
            ->verifications
            ->create($receiverNumber, "sms");

       return $client;

    } catch (Exception $e) {
        return $e->getMessage();
    }
}

?>