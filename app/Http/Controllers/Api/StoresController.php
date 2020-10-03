<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Stores;
use Illuminate\Http\Request;

class StoresController extends Controller
{
    public function index() {
        return respnse()->json(['x' => 'y']);
        $stores = Stores::all();

        return response()->json([
            'stores' => $stores
        ]);
    }

    public function show(Stores  $store) {
        if(!auth()->user()->tokenCan('stores')) {
            abort(403, 'Unauthorized');
        }
    }
}
