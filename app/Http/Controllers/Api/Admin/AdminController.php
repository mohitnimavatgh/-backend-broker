<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\Admin\AdminInterface;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct(AdminInterface $AdminInterface)
    {
        $this->admin = $AdminInterface;
    }

    public function getUserList(Request $request)
    {
        try {
            return $this->admin->getUserList($request);
        }catch (\Exception $e) {
            return $this->sendError($e, $e->getMessage() , $e->getCode());
       }
    }

    public function getBrokerPlanList(Request $request)
    {
        try {
            return $this->admin->getBrokerPlanList($request);
        }catch (\Exception $e) {
            return $this->sendError($e, $e->getMessage() , $e->getCode());
       }
    }

    public function getPlanUser(Request $request)
    {
        try {
            return $this->admin->getPlanUser($request);
        }catch (\Exception $e) {
            return $this->sendError($e, $e->getMessage() , $e->getCode());
       }
    }

    public function planFeaturesList(Request $request)
    {
        try {
            return $this->admin->planFeaturesList($request);
        }catch (\Exception $e) {
            return $this->sendError($e, $e->getMessage() , $e->getCode());
       }
    }
}
