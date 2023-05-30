<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\User\Auth\UserAuthController;
use App\Http\Controllers\Api\Broker\Auth\BrokerAuthController;

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
});

Route::group(['prefix'=>'user'], function () {
    Route::post('/user-mobile-rgisiter', [UserAuthController::class, 'userRigster']);
    Route::post('/user-verification', [UserAuthController::class, 'userVerification']);
    Route::post('/user-details', [UserAuthController::class, 'userDetails']);
    Route::post('/user-getpin', [UserAuthController::class, 'userGetLoginPin']);
    Route::post('/user-login', [UserAuthController::class, 'userlogin']);
});

// Route::group(['prefix' => 'admin','middleware' => ['auth:api','role:admin']], function () {
//     // Route::get('/adminInfo', [AuthController::class, 'adminInfo']);
// });

// Route::group(['prefix' => 'user','middleware' => ['auth:api','role:user']], function () {
//     Route::post('/mobile-rgisiter', [UserAuthController::class, 'userRigster']);
//     // Route::post('/user-verification', [UserAuthController::class, 'userVerification']);
//     // Route::get('/userInfo', [AuthController::class, 'userInfo']);
//     // Route::get('/profile', [AuthController::class, 'profile']);
// });

// Route::group(['prefix' => 'seller','middleware' => ['auth:api','role:seller']], function () {
//     Route::get('/userInfo', [AuthController::class, 'userInfo']);
//     // Route::get('/profile', [AuthController::class, 'profile']);
// });