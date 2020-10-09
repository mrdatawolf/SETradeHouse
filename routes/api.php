<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::apiResource('trends', 'Api\TrendsController')->middleware('auth:sanctum');
Route::apiResource('stores', 'Api\StoresController')->middleware('auth:sanctum');
Route::apiResource('data', 'Api\DataStatusController')->middleware('auth:sanctum');

/* Specific routes to match the web options */
Route::apiResource('stocklevels', 'Api\StocklevelsController')->middleware('auth:sanctum');


