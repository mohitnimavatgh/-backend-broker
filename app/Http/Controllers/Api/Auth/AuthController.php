<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PeterPetrus\Auth\PassportToken;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Auth;
use Validator;
use Mail;
use App\Models\User;
use App\Models\Role;

class AuthController extends Controller
{
    public function register(Request $request){
        try{
            $rules=[
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password'=>'required',
                'user_type'=>'required'
               ];

            $validator = Validator::make($request->all(),$rules);
            if ($validator->fails())
            {
                return response()
                    ->json(['status' => false, 'status_code' => 422, 'message' => $validator->errors() ], 422);
            }
           
            $user=User::create([
                 'name' => $request->name,
                 'role_name' => $request->name,
                 'email' => $request->email,
                 'mobile_no' => $request->mobile_no,
                 'mobile_verification' => 0,
                 'password' => bcrypt($request->password),
                 'visible_password' => $request->password,
           ]);

        //    $role=Role::find($request->user_type);
        //    $user->assignRole($role);  
           
        //    $decode_id = base64_encode($user->id);
        //    $email_id = base64_encode($user->email);
        //    $data = url('api/verify/email/'.$decode_id.'?ve='.$email_id);
        //    $email =  $request->email;
        //    $status = mailsend($email,$data);  
            
           if($user){
            return response()->json(['status' => true, 'status_code' => 200, 'data' =>$user->id,'message'=>'SuccessFully added'], 200);
           }else{
            return response()->json(['status' => false, 'status_code' => 404, 'data' =>'','message'=>'Something want to wrong..!'], 404);
           }          
            
        }catch(\Exception $e){
            return response()->json(['status' => false, 'message' => $e->getMessage() ], 500);
        }
    }

    public function login(Request $request)
    {
        try
        {
            $rules = ['email' => 'required', 'password' => 'required'];
            $validator = Validator::make($request->all() , $rules, 
                         $messages = ['email.required' => 'Username or email is required', 'password.required' => 'password is required']);

            if ($validator->fails())
            {
                return response()->json(['status' => false, 'status_code' => 422, 'message' => $validator->errors() ], 422);
            } 
            
            $fieldType = filter_var($request->email, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
            if (!auth()
                ->attempt(array(
                $fieldType => $request->email,
                'password' => $request->password,
                )))
            {
                return response()->json(['status' => false, 'message' => 'Invalid Credentials'], 400);
            }

            // if(!auth()->user()->email_verified_at){
            //     Auth::logout();
            //     return response()->json(['status' => false, 'message' => 'please verify your email address !'], 400);
            // }

            $accessToken = auth()->user()
                ->createToken('authToken')->accessToken;
            $user = auth()->user();  
            $role = $user->roles->pluck('name')->first();
            $user_data=$user;                
            $user_data['role'] = $role; 
           
            return response()->json(['status' => true, 'status_code' => 200, 'data' => $user_data,'access_token'=>$accessToken], 200);
        }
        catch(\Exception $e)
        {
            return response()->json(['status' => false, 'status_code' => 500, 'message' => $e->getMessage() ], 500);
        }
    }

    public function logout(){
        try
        {
            $auth_user = Auth::user()->token();
            $auth_user->revoke();
            return response()->json(['status' => true, 'status_code' => 200, 'data' =>''], 200);
        }
        catch(\Exception $e)
        {
            return response()->json(['status' => false, 'status_code' => 500, 'message' => $e->getMessage() ], 500);
        }
    }

    public function userInfo(){
        try{
            $user = auth()->user();  
            $role= $user->roles->pluck('name')->first();
            $user_data=$user;                
            $user_data['role'] = $role;       
            return response()->json(['status' => true, 'data' => $user_data], 200);
        }
        catch(\Exception $e)
        {
            return response()->json(['status' => false, 'message' => $e->getMessage() ], 500);
        }
    }

    public function profile(){
        try{
            $user = auth()->user();  
            $role= $user->roles;
            $user_data=$user;                
            $user_data['role'] = $role;       
            return response()->json(['status' => true, 'data' => $user_data], 200);
        }
        catch(\Exception $e)
        {
            return response()->json(['status' => false, 'message' => $e->getMessage() ], 500);
        }
    }
}
