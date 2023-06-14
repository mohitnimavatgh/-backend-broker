<?php

namespace App\Http\Controllers\Api\Payment;

use App\Http\Controllers\Controller;
use App\Interfaces\Payment\StripePaymentInterface;
use Illuminate\Http\Request;
use Validator;

class StripePaymentController extends Controller
{
    public function __construct(StripePaymentInterface $stripePaymentRepositorys)
    {
        $this->stripePayment = $stripePaymentRepositorys;
    }

    public function stripePayment(Request $request){
       return $this->stripePayment->stripePayment($request);
    }

    public function stripeAddPlan(Request $request){
        return $this->stripePayment->stripeAddPlan($request);
     }
}