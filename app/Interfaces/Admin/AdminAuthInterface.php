<?php

namespace App\Interfaces\Admin;


interface AdminAuthInterface {
    public function adminlogin($request);
    public function adminChangePassword($request);
}