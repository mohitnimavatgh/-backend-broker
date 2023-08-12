<?php

namespace App\Interfaces\Broker;


interface PlanInterface {

    public function allPlanLists($request);

    public function planCreate($request);
    public function planUpdate($request);
    public function planList($request);
    public function getPlan($id);
    public function planDelete($id);

    public function planFeaturesCreate($request);
    public function planFeaturesUpdate($request);
    public function planFeaturesList($request);
    public function getPlanFeatures($request);
    public function planFeaturesDelete($id);
}