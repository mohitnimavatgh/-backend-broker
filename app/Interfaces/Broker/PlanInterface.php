<?php

namespace App\Interfaces\Broker;


interface PlanInterface {

    public function planCreateOrUpdate($request);
    public function planList($request);
    public function getPlan($id);
    public function planDelete($id);

    public function planFeaturesCreateOrUpdate($request);
    public function planFeaturesList($request);
    public function getPlanFeatures($request);
    public function planFeaturesDelete($id);
}