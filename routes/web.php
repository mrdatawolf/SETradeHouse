<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();
Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');
Route::get('/', 'HomeController@index')->name('root');
Route::group(['middleware' => ['auth', 'session.data']], function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/welcome', function () {
        return view('welcome');
    })->name('welcome');

    Route::prefix('/orders')->group(function () {
        Route::get('ores', 'Orders@ores')->name('orders.ores');
        Route::get('ingots', 'Orders@ingots')->name('orders.ingots');
        Route::get('components', 'Orders@components')->name('orders.components');
        Route::get('tools', 'Orders@tools')->name('orders.tools');
    });
    Route::prefix('/offers')->group(function () {
        Route::get('ores', 'Offers@ores')->name('offers.ores');
        Route::get('ingots', 'Offers@ingots')->name('offers.ingots');
        Route::get('components', 'Offers@components')->name('offers.components');
        Route::get('tools', 'Offers@tools')->name('offers.tools');
    });
    Route::get('/stocklevels', 'Stocklevels@index')->name('stocklevels');
    Route::prefix('/stores')->group(function () {
        Route::get('your', 'Stores@index')->name('stores');
        Route::get('world', 'Stores@worldIndex')->name('stores.world');
        Route::get('server', 'Stores@serverIndex')->name('stores.server');
    });
    Route::prefix('/profitvsloss')->group(function () {
        Route::get('your', 'ProfitLoss@index')->name('profitvsloss');
        Route::get('world', 'ProfitLoss@worldIndex')->name('profitvsloss.world');
        Route::get('server', 'ProfitLoss@serverIndex')->name('profitvsloss.server');
    });
});
//trends
Route::group(['middleware' => ['auth', 'session.data']], function () {
    Route::prefix('/trends')->group(function () {
        Route::prefix('/ores')->group(function () {
            Route::get('/', 'Trends@oresOfferIndex')->name('trends.ores');
            Route::get('/orders', 'Trends@oresOrderIndex')->name('trends.ores.orders');
            Route::get('/offers', 'Trends@oresOfferIndex')->name('trends.ores.offers');
        });
        Route::prefix('/ingots')->group(function () {
            Route::get('/', 'Trends@ingotsOfferIndex')->name('trends.ingots.offers');
            Route::get('/orders', 'Trends@ingotsOrderIndex')->name('trends.ingots.orders');
            Route::get('/offers', 'Trends@ingotsOfferIndex')->name('trends.ingots.offers');
        });
        Route::prefix('/components')->group(function () {
            Route::get('/', 'Trends@componentsOfferIndex')->name('trends.components');
            Route::get('/orders', 'Trends@componentsOrderIndex')->name('trends.components.orders');
            Route::get('/offers', 'Trends@componentsOfferIndex')->name('trends.components.offers');
        });
        Route::prefix('/tools')->group(function () {
            Route::get('/', 'Trends@toolOfferIndex')->name('trends.tools');
            Route::get('/orders', 'Trends@toolsOfferIndex')->name('trends.tools.orders');
            Route::get('/offers', 'Trends@toolsOfferIndex')->name('trends.tools.offers');
        });
    });
});
//tests
Route::group(['middleware' => ['auth', 'session.data']], function () {
    Route::prefix('/test')->group(function () {
        Route::get('/test1', 'Tests@test1')->name('test.test1');
    });
});
