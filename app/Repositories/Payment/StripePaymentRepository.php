<?php

namespace App\Repositories\Payment;

use App\Interfaces\Payment\StripePaymentInterface as StripePaymentInterface;
use App\Models\PurchasePlan;
use App\Models\User;
use Stripe;
use Stripe\Token;
use PaymentIntent;
use Stripe\paymentMethods;
use Laravel\Cashier\Cashier;
use Razorpay\Api\Api;

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
        $stripe = Cashier::stripe();

        $planDelete = $stripe->products->delete(
            $request->product_id,
        );
        return sendResponse(true,200,'Plan Deleted successfully',$planDelete);
    }

    public function stripePlanPriceUpdate($request)
    {
        $stripe = Cashier::stripe();

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

    public function stripeToBankAccountCreate($request)
    {
        $stripe = Cashier::stripe();

        $token = $stripe->tokens->create([
            'bank_account' => [
                'country' => $request->country,
                'currency' => $request->currency,
                'account_holder_name' => $request->account_holder_name,
                'account_number' => $request->account_number,
                'account_holder_type' => 'individual',
                'routing_number' => $request->routing_number,
                'metadata' => [
                    'ifsc_code' => $request->ifsc_code,
                ],
            ],
        ]);
        
        $customer = $stripe->customers->create([
            'email' => $request->input('email'),
            'source' => $token->id,
        ]);

        $verify = $stripe->customers->verifySource(
            $customer->id,
            $token->bank_account->id,
            ['amounts' => [32, 45]]
        );

        // $account = $stripe->accounts->create([
        //     'type' => 'standard',
        //     'country' => 'US',
        //     'email' => 'jenny.rosen@example.com',
        // ]);

        // $abv = $stripe->payouts->create([
        //     'amount' => 10,
        //     'currency' => 'usd',
        //     'destination' => $account->id
        // ]);
        
        // return sendResponse(true,200,'Bank Account Created successfully',$abv);

          $account = $stripe->accounts->create([
            'type' => 'standard',
            'country' => 'IN',
            'email' => 'jenny.rosen@example.com',
        ]);

        // $account_token = $stripe->tokens->create([
        //     'account' => [
        //       'individual' => [
        //         'first_name' => 'Jane',
        //         'last_name' => 'Doe',
        //       ],
        //       'tos_shown_and_accepted' => true,
        //     ],
        //   ]);

        // $account = $stripe->accounts->create([
        //     'type' => 'custom',
        //     'country' => 'US',
        //     'email' => 'jenny.rosen@example.com',
        //     'capabilities' => [
        //       'card_payments' => ['requested' => true],
        //       'transfers' => ['requested' => true],
        //     ],
        // ]);
        // $account = $stripe->accounts->create([
        //     'type' => 'custom',
        //     'country' => 'US',
        //     'email' => 'jenny.rosen@example.com',
        //     'capabilities' => [
        //       'card_payments' => ['requested' => true],
        //       'transfers' => ['requested' => true],
        //     ],
        //   ]);

        // $acc = $stripe->tokens->create([
        //     'account' => [
        //       'individual' => [
        //         'first_name' => 'Jane',
        //         'last_name' => 'Doe',
        //       ],
        //       'tos_shown_and_accepted' => true,
        //     ],
        //   ]);

        // $account = $stripe->accounts->create([
        //     'type' => 'custom',
        //     'country' => 'IN',
        //     'email' => 'jenny.rosen@example.com',
        //     'account_token' => $acc->id,
        //     'capabilities' => [
        //       'card_payments' => ['requested' => true],
        //       'transfers' => ['requested' => true],
        //     ],
        //   ]);

        $transfer = $stripe->transfers->create([
            'amount' => 100, // Amount in cents
            'currency' => 'inr',
            'destination' => $account->id, // The ID of the connected bank account
        ]);
        // $data['token'] = $token;
        // $data['token'] = $token;
        // $data['customer'] = $customer;
        $data['account'] = $account;
        // $data['verify'] = $verify;
        // $data['transfe'] = $transfe;
        // $data['verify'] = $verify;

        return sendResponse(true,200,'Bank Account Created successfully',$data);

    }

    public function stripeToBankTransferMoney($request)
    {
        $stripe = Cashier::stripe();

        $transfer = $stripe->transfer->create([
            'amount' => 1000, // Amount in cents
            'currency' => 'usd',
            'destination' => 'bank_account_id', // The ID of the bank account to transfer funds to
        ]);

        // Output the transfer object
        return sendResponse(true,200,'Transfer Money successfully',$transfer);
    }

    public function razorpayApiIntegration($request)
    {
        $api_key = 'rzp_test_p0fFVL0neEe8Gc';
        $api_secret = '1p6KaJPemoYJt5ne92yD2eJ6';
        
        $api = new Api($api_key, $api_secret);
        
        // Collect card details from the form
        $card_number = $_POST['card_number'];
        $expiry_month = $_POST['expiry_month'];
        $expiry_year = $_POST['expiry_year'];
        $cvv = $_POST['cvv'];
        $cardholder_name = $_POST['cardholder_name'];
        
        // Create a new Razorpay order
        $order = $api->order->create([
            'amount' => 1000, // Amount in paise (e.g., 1000 paise = ₹10)
            'currency' => 'INR',
            'receipt' => 'order_12345', // Unique identifier for the order
        ]);
        
        $order_id = $order->id;
        
        
        // Create a payment using the card details
        $payment = $api->payment->fetch($order_id)->capture([
            'amount' => 1000, // Amount in paise (e.g., 1000 paise = ₹10)
            'payment_capture' => 1,
            'card' => [
                'number' => $card_number,
                'expiry_month' => $expiry_month,
                'expiry_year' => $expiry_year,
                'cvv' => $cvv,
                'card_holder_name' => $cardholder_name,
            ],
        ]);
        
        if ($payment->status === 'captured') {
            // Payment successful
            // Process further actions (e.g., order fulfillment, database updates, etc.)
            echo 'Payment successful';
        } else {
            // Payment failed
            echo 'Payment failed';
        }
    }
}