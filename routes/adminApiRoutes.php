<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Admin\Auth\AdminAuthController;
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

Route::group(['prefix' => 'admin'], function () {
    Route::post('/admin-login', [AdminAuthController::class, 'adminlogin']);
    Route::post('passwordForgot-salesMarketing', [SalesMarketingController::class, 'passwordForgot']);
    Route::middleware(['auth:api','admin'])->group(function () {
        Route::get('list-salesMarketing', [SalesMarketingController::class, 'list']);
        Route::post('add-salesMarketing', [SalesMarketingController::class, 'add']);
        Route::get('delete-salesMarketing/{id}', [SalesMarketingController::class, 'delete']);
        Route::post('edit-salesMarketing', [SalesMarketingController::class, 'edit']);
    });
});
