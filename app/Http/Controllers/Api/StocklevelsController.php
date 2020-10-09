<?php namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Stocklevels;
use Illuminate\Http\Request;

class StocklevelsController extends Controller
{
    public function index() {
        if(!auth()->user()->tokenCan('read')) {
            abort(403, 'Unauthorized');
        }
        $stocklevel = new Stocklevels();

        return response()->json([
            'stocklevels' => $stocklevel->getStockLevels()
        ]);
    }

    public function show() {
        if(!auth()->user()->tokenCan('read')) {
            abort(403, 'Unauthorized');
        }

        return response()->json([
            'stocklevels' => 'Comming Soon'
        ]);
    }
}
