<?php

namespace App\Interfaces\User;


interface UserAuthInterface {

    public function userRigster($request);
    public function userVerification($request);
    public function userDetails($request);
    public function userGetLoginPin($request);
    public function userlogin($request);
    public function userPasswordForgot($request);
    public function userChangePassword($request);
}