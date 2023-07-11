<?php

namespace App\Interfaces\Admin;


interface RateOfInterestInterface {
    public function RateOfInterestsList($request);
    public function RateOfInterestsCreate($request);
    public function RateOfInterestsUpdate($request);
    public function RateOfInterestsDelete($request);
}