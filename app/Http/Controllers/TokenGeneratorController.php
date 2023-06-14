<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Cashier\Cashier;

class TokenGeneratorController extends Controller
{
    public function indexAction(){
        $intent = auth()->user()->createSetupIntent();
        print_r($intent);
    }

    public function subscription(Request $request)
    {
        print_r($request->token);
    }

    public function viewCard(){
        return view("subscription");
    }
}
