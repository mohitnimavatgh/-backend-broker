<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Payment\StripePaymentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['prefix'=>'user'], function () {
    Route::middleware(['auth:api','user'])->group(function () {
        Route::post('/user-payment', [StripePaymentController::class, 'stripePayment']);     
    });
});

Route::group(['prefix'=>'admin'], function () {
    Route::middleware(['auth:api','admin'])->group(function () {
        Route::post('/account-create', [StripePaymentController::class, 'stripeToBankAccountCreate']);
        // Route::post('/account-create', [StripePaymentController::class, 'razorpayApiIntegration']);
        Route::post('/money-transfer-bank', [StripePaymentController::class, 'stripeToBankTransferMoney']);
    });
});
