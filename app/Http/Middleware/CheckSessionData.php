<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Stocklevels;
use App\Http\Controllers\Stores;
use Closure;
use \Session;

class CheckSessionData
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(! Session::has('stockLevels'))
        {
            $this->setStockData();
        }
        if(! Session::has('stores'))
        {
            $this->setStoreData();
        }
        return $next($request);
    }

    public function setStockData()
    {
        $stockController = new Stocklevels();
        $stockLevels = $stockController->getStockLevels();
        Session::put('stockLevels', $stockLevels);
    }

    public function setStoreData()
    {
        $storeController = new Stores();
        $stores = $storeController->getStores();
        Session::put('stores', $stores);
    }
}
