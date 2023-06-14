<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Broker\Auth\BrokerAuthController;
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

        //Plan Create Api
        Route::post('/plan/create/{id?}', [PlanController::class, 'planCreateOrUpdate']);
        Route::get('/plan/list/{id?}', [PlanController::class, 'planList']);
        Route::get('/plan/get-plan/{id?}', [PlanController::class, 'getPlan']);
        Route::get('/plan/delete/{id}', [PlanController::class, 'planDelete']);

        //Plan Features Create Api
        Route::post('/planFeatures/create/{id?}', [PlanController::class, 'planFeaturesCreateOrUpdate']);
        Route::get('/planFeatures/list', [PlanController::class, 'planFeaturesList']);
        Route::get('/planFeatures/get-plan/{id?}', [PlanController::class, 'getPlanFeatures']);
        Route::get('/planFeatures/delete/{id}', [PlanController::class, 'planFeaturesDelete']);
    });
});