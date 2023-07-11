<?php

namespace App\Interfaces\Admin;


interface AdminInterface {
    public function getUserList($request);
    public function getBrokerPlanList($request);
    public function planFeaturesList($request);
}