<?php

namespace App\Interfaces\Payment;


interface StripePaymentInterface {

    public function stripePayment($request);
    public function stripeAddPlan($request);
    public function stripePlanDelete($request);
    public function stripePlanPriceUpdate($request);
}