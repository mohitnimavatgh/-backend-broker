<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Broker\Auth\BrokerAuthController;
use App\Http\Controllers\Api\Payment\StripePaymentController;
use App\Http\Controllers\Api\Broker\PlanController;
use App\Http\Controllers\Api\Broker\BrokerController;

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

Route::group(['prefix'=>'broker'], function () {
    Route::post('/broker-mobile-rgisiter', [BrokerAuthController::class, 'brokerRigster']);
    Route::post('/broker-verification', [BrokerAuthController::class, 'brokerVerification']);
    Route::post('/broker-details', [BrokerAuthController::class, 'brokerDetails']);
    Route::post('/broker-getpin', [BrokerAuthController::class, 'brokerGetLoginPin']);
    Route::post('/broker-certificatedDetails', [BrokerAuthController::class, 'brokerCertificatedDetailsForWork']);
    Route::post('/broker-login', [BrokerAuthController::class, 'brokerlogin']);
    Route::post('/broker-passwordForgot', [BrokerAuthController::class, 'brokerPasswordForgot']);
    Route::middleware(['auth:api','broker'])->group(function () {
        Route::post('/broker-changePassword', [BrokerAuthController::class, 'brokerChangePassword']);
        Route::get('/list', [BrokerController::class, 'brokerList']);
        Route::get('/subscribeUser/{id}', [BrokerController::class, 'subscribeUser']);

        //Plan Create Api
        Route::group(['prefix'=>'plan'], function () {
            Route::post('/create/{id?}', [PlanController::class, 'planCreateOrUpdate']);
            Route::get('/list/{id?}', [PlanController::class, 'planList']);
            Route::get('/get-plan/{id?}', [PlanController::class, 'getPlan']);
            Route::get('/delete/{id}', [PlanController::class, 'planDelete']);
        });

        //Plan Features Create Api
        Route::group(['prefix'=>'planFeatures'], function () {
            Route::post('/create/{id?}', [PlanController::class, 'planFeaturesCreateOrUpdate']);
            Route::get('/list/{plan_id?}', [PlanController::class, 'planFeaturesList']);
            Route::get('/get-plan/{id?}', [PlanController::class, 'getPlanFeatures']);
            Route::get('/delete/{id}', [PlanController::class, 'planFeaturesDelete']);
        });

        //Stripe Add Plan
        Route::post('/broker-addPlan', [StripePaymentController::class, 'stripeAddPlan']);

    });
});