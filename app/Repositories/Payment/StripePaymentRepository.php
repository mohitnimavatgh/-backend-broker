<?php

namespace App\Repositories\Payment;

use App\Interfaces\Payment\StripePaymentInterface as StripePaymentInterface;
use App\Models\PurchasePlan;
use App\Models\User;
use Stripe;
use PaymentIntent;
use Stripe\paymentMethods;
use Laravel\Cashier\Cashier;

class StripePaymentRepository implements StripePaymentInterface
{
    public function stripePayment($request)
    {

        $stripe = Cashier::stripe();

        $customer = $stripe->customers->create([
            "email" => $request->email,
            "name" => $request->name,
            "payment_method"=> "pm_1NIVw4SEmyiCNJGSHLWZmFMb",
            "invoice_settings"=> [
                "default_payment_method"=> 'pm_1NIVw4SEmyiCNJGSHLWZmFMb' 
            ],
            "address" => [
                "line1" => 'varchha Road 1',
                "city" => 'surat',
                "postal_code" => '35006',
                "state" => 'gujarat',
                "country" => 'IN',
            ],
        ]);
        
        $custSubscription =  $stripe->subscriptions->create([
            'customer' => $customer->id,
            'items' => [
              ['price' => 'price_1NI45qSEmyiCNJGSeXxeNTMN'],
            ],
            'off_session' => true,
          ]);

        return sendResponse(true,200,'Payment successfully',$custSubscription);
    }

    public function stripeAddPlan($request)
    {
        $stripe = Cashier::stripe();
  
        $product = $stripe->products->create([
            'name' => $request->plan_name,
            'type' => 'service',
        ]);
        
        $prices = $stripe->prices->create([
            'unit_amount' => $request->plan_price * 100,
            'currency' => env('CASHIER_CURRENCY'),
            'recurring' => ['interval' => $request->plan_duration],
            'product' =>  $product->id,
        ]);       
        
        $data['product'] = $product;
        $data['prices'] = $prices;
       
        return sendResponse(true,200,'Plan Created successfully',$data);
    }

    public function stripePlanDelete($request)
    {
        $planDelete = $stripe->products->delete(
            $request->product_id,
        );
        return sendResponse(true,200,'Plan Deleted successfully',$planDelete);
    }

    public function stripePlanPriceUpdate($request)
    {
        $prices = $stripe->prices->create([
            'unit_amount' => $request->amount * 100,
            'currency' => 'inr',
            'recurring' => ['interval' => $request->duration],
            'product' =>  $request->product_id,
            'active' => true,
        ]);   
        
        $pricesUpdate = $stripe->products->update(
            $request->product_id,
            ['default_price' => $prices->id]
        );
        return sendResponse(true,200,'Plan prices updated successfully',$pricesUpdate);
    }
}