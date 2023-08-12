<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\User\Auth\UserAuthController;
use App\Http\Controllers\Api\User\PurchasePlanController;
use App\Http\Controllers\Api\Broker\PlanController;

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
    Route::get('/user-mobile-rgisiter', [UserAuthController::class, 'userRigster']);
    Route::get('/user-verification', [UserAuthController::class, 'userVerification']);
    Route::post('/user-details', [UserAuthController::class, 'userDetails']);
    Route::get('/user-getpin', [UserAuthController::class, 'userGetLoginPin']);
    Route::post('/user-login', [UserAuthController::class, 'userlogin']);
    Route::post('/user-passwordForgot', [UserAuthController::class, 'userPasswordForgot']);
    Route::middleware(['auth:api','user'])->group(function () {
        Route::post('/user-changePassword', [UserAuthController::class, 'userChangePassword']);
        Route::post('/plan-purchase', [PurchasePlanController::class, 'userPurchasePlan']);
        Route::get('/get-userPurchasePlan/{id?}', [PurchasePlanController::class, 'getuserPurchasePlan']);
    });

    Route::get('/allPlanLists', [PlanController::class, 'allPlanLists']);
});