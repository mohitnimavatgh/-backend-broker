<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Admin\Auth\AdminAuthController;
use App\Http\Controllers\Api\Admin\AdminController;
use App\Http\Controllers\Api\Admin\SalesMarketingController;
use App\Http\Controllers\Api\Admin\RateOfInterestController;

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

Route::group(['prefix' => 'admin'], function () {
    Route::post('/login', [AdminAuthController::class, 'adminlogin']);
    Route::get('salesMarketing-passwordForgotSendMail', [SalesMarketingController::class, 'passwordForgotForSendMail']);
    Route::post('salesMarketing-forgotPasswordSet', [SalesMarketingController::class, 'passwordForgotSet']);
    Route::get('salesMarketing-verification', [SalesMarketingController::class, 'userVerification']);
    Route::middleware(['auth:api','admin'])->group(function () {

        Route::get('/get-userList/{role?}', [AdminController::class, 'getUserList']);
        Route::get('/get-brokerPlanList/{broker_id?}', [AdminController::class, 'getBrokerPlanList']);
        Route::get('/get-planUser/{plan_id}', [AdminController::class, 'getPlanUser']);
        Route::get('/broker/plans/features/{plan_id}', [AdminController::class, 'planFeaturesList']);

        Route::group(['prefix' => 'rateOfInterest'], function () {
            Route::get('/list/{id?}', [RateOfInterestController::class, 'RateOfInterestsList']);
            Route::post('/create', [RateOfInterestController::class, 'RateOfInterestsCreate']);
            Route::post('/edit', [RateOfInterestController::class, 'RateOfInterestsUpdate']);
            Route::get('/delete/{id}', [RateOfInterestController::class, 'RateOfInterestsDelete']);
        });

        Route::group(['prefix' => 'salesMarketing'], function () {
            Route::get('/list/{user_id?}', [SalesMarketingController::class, 'list']);
            Route::post('/add', [SalesMarketingController::class, 'add']);
            Route::post('/edit', [SalesMarketingController::class, 'edit']);
            Route::get('/delete/{user_id}', [SalesMarketingController::class, 'delete']);
        });
    });
});
