<?php

namespace App\Interfaces\Payment;


interface StripePaymentInterface {

    public function stripePayment($request);
    public function stripeAddPlan($request);
    public function stripePlanDelete($request);
    public function stripePlanPriceUpdate($request);
    public function stripeToBankAccountCreate($request);
    public function stripeToBankTransferMoney($request);
    public function razorpayApiIntegration($request);
}