<?php

namespace App\Interfaces\Admin;


interface SalesMarketingInterface {
    public function list($request);
    public function add($request);
    public function edit($id);
    public function delete($id);
    public function userVerification($request);
    public function passwordForgotSet($request);
    public function passwordForgotForSendMail($request);
}