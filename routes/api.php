<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Admin\Auth\AdminAuthController;
use App\Http\Controllers\Api\User\Auth\UserAuthController;
use App\Http\Controllers\Api\Broker\Auth\BrokerAuthController;
use App\Http\Controllers\Api\Admin\SalesMarketingController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['prefix'=>'broker'], function () {
    Route::post('/broker-mobile-rgisiter', [BrokerAuthController::class, 'brokerRigster']);
    Route::post('/broker-verification', [BrokerAuthController::class, 'brokerVerification']);
    Route::post('/broker-details', [BrokerAuthController::class, 'brokerDetails']);
    Route::post('/broker-getpin', [BrokerAuthController::class, 'brokerGetLoginPin']);
    Route::post('/broker-certificatedDetails', [BrokerAuthController::class, 'brokerCertificatedDetailsForWork']);
    Route::post('/broker-login', [BrokerAuthController::class, 'userlogin']);
    Route::middleware(['auth:api','broker'])->group(function () {

    });
});

Route::group(['prefix'=>'user'], function () {
    Route::post('/user-mobile-rgisiter', [UserAuthController::class, 'userRigster']);
    Route::post('/user-verification', [UserAuthController::class, 'userVerification']);
    Route::post('/user-details', [UserAuthController::class, 'userDetails']);
    Route::post('/user-getpin', [UserAuthController::class, 'userGetLoginPin']);
    Route::post('/user-login', [UserAuthController::class, 'userlogin']);
    Route::middleware(['auth:api','user'])->group(function () {

    });
});

Route::group(['prefix' => 'admin'], function () {
    Route::post('/admin-login', [AdminAuthController::class, 'adminlogin']);
    Route::middleware(['auth:api','admin'])->group(function () {
        Route::get('list-salesMarketing', [SalesMarketingController::class, 'list']);
        Route::post('add-salesMarketing', [SalesMarketingController::class, 'add']);
        Route::get('delete-salesMarketing/{id}', [SalesMarketingController::class, 'delete']);
        Route::post('edit-salesMarketing', [SalesMarketingController::class, 'edit']);
    });
});
