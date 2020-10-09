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


Route::apiResource('stocklevels', 'Api\StocklevelsController')->middleware('auth:sanctum');
//store specific routes
Route::group(['middleware' => ['auth:sanctum', 'session.data']], function () {
    Route::prefix('/stores')->group(function () {
        Route::get('/personal', 'Api\StoresController@personal');
        Route::get('/world', 'Api\StoresController@world');
        Route::get('/server', 'Api\StoresController@server');
    });
    Route::prefix('/trends')->group(function () {
        Route::prefix('/ores')->group(function () {
            Route::middleware('auth:sanctum')->get('/orders', 'Api\TrendsController@oresOrders');
            Route::middleware('auth:sanctum')->get('/offers', 'Api\TrendsController@oresOffers');
        });
        Route::prefix('/ingots')->group(function () {
            Route::middleware('auth:sanctum')->get('/orders', 'Api\TrendsController@ingotsOrders');
            Route::middleware('auth:sanctum')->get('/offers', 'Api\TrendsController@ingotsOffers');
        });
        Route::prefix('/components')->group(function () {
            Route::middleware('auth:sanctum')->get('/orders', 'Api\TrendsController@componentsOrders');
            Route::middleware('auth:sanctum')->get('/offers', 'Api\TrendsController@componentsOffers');
        });
        Route::prefix('/tools')->group(function () {
            Route::middleware('auth:sanctum')->get('/orders', 'Api\TrendsController@toolsOrders');
            Route::middleware('auth:sanctum')->get('/offers', 'Api\TrendsController@toolsOffers');
        });
    });
});
Route::apiResource('stores', 'Api\StoresController')->middleware('auth:sanctum');
Route::apiResource('trends', 'Api\TrendsController')->middleware('auth:sanctum');
//other routes
Route::apiResource('data', 'Api\DataStatusController')->middleware('auth:sanctum');
