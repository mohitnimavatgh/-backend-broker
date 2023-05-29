<?php

use App\Http\Controllers\Api\Admin\SalesMarketingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\User\Auth\UserAuthController;

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

Route::group(['prefix'=>'{prefix}'], function () {
    Route::post('/mobile-rgisiter', [UserAuthController::class, 'userRigster']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});

Route::group(['prefix' => 'admin','middleware' => ['auth:api','role:admin']], function () {
    Route::get('/adminInfo', [AuthController::class, 'adminInfo']);
    Route::get('/profile', [AuthController::class, 'profile']);
});

Route::group(['prefix' => 'user','middleware' => ['auth:api','role:user']], function () {
    Route::get('/userInfo', [AuthController::class, 'userInfo']);
    Route::get('/profile', [AuthController::class, 'profile']);
});

Route::group(['prefix' => 'seller','middleware' => ['auth:api','role:seller']], function () {
    Route::get('/userInfo', [AuthController::class, 'userInfo']);
    Route::get('/profile', [AuthController::class, 'profile']);
});
Route::group(['prefix' => 'sales-marketing','middleware' => ['auth:api','role:seller']], function () {
    Route::get('list', [SalesMarketingController::class, 'list']);
    Route::post('add', [SalesMarketingController::class, 'add']);
    Route::get('delete/{id}', [SalesMarketingController::class, 'delete']);
    Route::post('edit', [SalesMarketingController::class, 'edit']);
});