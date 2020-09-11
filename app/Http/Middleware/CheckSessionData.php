<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Stocklevels;
use App\Http\Controllers\Stores;
use App\NpcStorageValues;
use App\Transactions;
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
    public function handle($request, Closure $next) {
        if(! Session::has('stockLevels')) {
            $this->setStockData();
        }
        if(! Session::has('stores')) {
            $this->setStoreData();
        }
        if(! Session::has('serverId')) {
            $this->setGeneralValues();
        }

        if(! Session::has('newest_db_record')) {
            $this->setNewestDBRecordedDate();
        }

        if(! Session::has('newest_sync_record')) {
            $this->setNewestSyncRecordedDate();
        }

        return $next($request);
    }

    public function setStockData() {
        $stockController = new Stocklevels();
        $stockLevels = $stockController->getStockLevels();
        Session::put('stockLevels', $stockLevels);
    }

    public function setStoreData() {
        $storeController = new Stores();
        $stores = $storeController->getTransactionsUsingTitles();
        Session::put('stores', $stores);
    }

    public function setGeneralValues() {
        //these are placeholders.  It should be stored retrieved based on the players last selection
        $serverId = 1;
        $worldId = 1;
        $storeId = 1;

        Session::put('serverId', $serverId);
        Session::put('worldId', $worldId);
        Session::put('storeId', $storeId);
    }


    public function setNewestDBRecordedDate() {
        $npcStorageValue = NpcStorageValues::latest('origin_timestamp')->first();

        $originString = (empty($npcStorageValue->origin_timestamp)) ? 'N/A' : $npcStorageValue->origin_timestamp . ' -7';
        Session::put('newest_db_record', $originString);
    }


    public function setNewestSyncRecordedDate() {
        $transaction = Transactions::latest('updated_at')->first();
        $updatedAtString = (empty($transaction->updated_at)) ? 'N/A' : $transaction->updated_at->toDateTimeString() . ' +0';
        Session::put('newest_sync_record', $updatedAtString);
    }
}
