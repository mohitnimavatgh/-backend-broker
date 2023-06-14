<?php

namespace App\Interfaces\Broker;


interface PlanInterface {

    public function planCreateOrUpdate($request);
    public function planList($request);
    public function getPlan($id);
    public function planDelete($id);

    public function planFeaturesCreateOrUpdate($request);
    public function planFeaturesList();
    public function getPlanFeatures($id);
    public function planFeaturesDelete($id);
}