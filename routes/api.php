<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TokenGeneratorController;

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

Route::get('/card-view', [TokenGeneratorController::class, 'viewCard']);
Route::post('/subscription', [TokenGeneratorController::class, 'subscription'])->name("subscription.create");


Route::middleware(['auth:api','user'])->group(function () {
    Route::get('/card-token', [TokenGeneratorController::class, 'indexAction']);
});

require __DIR__.'/adminApiRoutes.php';
require __DIR__.'/userApiRoutes.php';
require __DIR__.'/brokerApiRoutes.php';
require __DIR__.'/paymentApiRoutes.php';

