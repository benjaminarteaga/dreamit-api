<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PersonController;
use App\Http\Controllers\Api\BuildingController;
use App\Http\Controllers\Api\AccessController;
use App\Http\Controllers\Api\BlockController;
use App\Http\Controllers\Api\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('persons', PersonController::class);

Route::apiResource('buildings', BuildingController::class);

Route::apiResource('accesses', AccessController::class);

Route::apiResource('blocks', BlockController::class);

Route::apiResource('users', UserController::class);