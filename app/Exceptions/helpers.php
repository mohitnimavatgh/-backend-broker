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

function curlFunction($data) {

    $method = $data['method'];
    $url = $data['url'];
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => $method,
    ));
    $response = curl_exec($curl);
    if (curl_errno($curl)) {
            $error_msg = curl_error($curl);
        }
    curl_close($curl);
    if (isset($error_msg)) {
        $data=[];
        $data['status']=false;
        $data['message']=$error_msg;
        return $data;
    }else{
    $result = json_decode($response);
       $data=[];
       $data['status']=true;
       $data['result']=$result;
       return $data;
    }
}

function sendOTP($no){
    try {
        $otp = rand(100000,999999);
        $receiverNumber = '+91'.$no;
        $message = "Your OTP verification code is: ".$otp;    
    
        $account_sid = 'AC1646d9cef27b0bbada6df4653eef10a2'; 
        $auth_token = 'd25d03b9d39e8b6f77a018ec99bee7a2';
        $twilio_number = '+13157137042';
        $twilio_verify_sid = 'VAb84e5fd30634edfc0c183f0c14af0bf0';

        $client = new Client($account_sid, $auth_token);
        $client->messages->create($receiverNumber, [
                'from' => $twilio_number, 
                'body' => $message]);
       return $otp;
    } catch (Exception $e) {
        return $e->code;
    }
}

function sendOTP2Factor($mobile_no) {
    $receiverNumber = '+91'.$mobile_no;
    $otp = rand(100000,999999);
    $otp_template_name = env('2Factor_otp_template_name');
    $api_key = env('2FactorAPIKEY');
    $data = [];
    $data['method'] = "GET";
    $data['url'] = "https://2factor.in/API/V1/$api_key/SMS/$receiverNumber/$otp/$otp_template_name";
    $response = curlFunction($data);
    return $response;
}

function otpVerification($payload) {
    $mobile_no = $payload['mobile_no'];
    $otp = $payload['otp'];
    $receiverNumber = '+91'.$mobile_no;
    $api_key = env('2FactorAPIKEY');
    $data = [];
    $data['method'] = "GET";
    $data['url'] = "https://2factor.in/API/V1/$api_key/SMS/VERIFY3/$receiverNumber/$otp";
    $response = curlFunction($data);
    return $response;
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