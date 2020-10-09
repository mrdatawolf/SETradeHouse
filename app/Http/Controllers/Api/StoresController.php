<?php namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Stores;
use  \App\Models\TradeZones;
use Illuminate\Http\Request;

class StoresController extends Controller
{
    public function index() {
        if(!auth()->user()->tokenCan('read')) {
            abort(403, 'Unauthorized');
        }
        $stores = TradeZones::all();

        return response()->json([
            'stores' => $stores
        ]);
    }

    public function show(TradeZones  $tradezone) {
        if(!auth()->user()->tokenCan('read')) {
            abort(403, 'Unauthorized');
        }

        return response()->json([
            'store' => $tradezone
        ]);
    }

    public function personal() {
        if(!auth()->user()->tokenCan('read')) {
            abort(403, 'Unauthorized');
        }
        $stores = new Stores();
        $store = $stores->getTransactionsOfOwner();

        return response()->json([
            'store' => $store
        ]);
    }

    public function world() {
        if(!auth()->user()->tokenCan('read')) {
            abort(403, 'Unauthorized');
        }
        $stores = new Stores();
        $store = $stores->getTransactionsUsingTitles();

        return response()->json([
            'store' => $store
        ]);
    }

    public function server() {
        if(!auth()->user()->tokenCan('read')) {
            abort(403, 'Unauthorized');
        }
        $stores = new Stores();
        $store = $stores->getTransactionsUsingTitles();

        return response()->json([
            'store' => $store
        ]);
    }
}
