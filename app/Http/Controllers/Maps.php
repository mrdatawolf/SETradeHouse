<?php

namespace App\Http\Controllers;

use App\Http\Traits\FindingGoods;
use App\Stores;

class Maps extends Controller
{
    public function nebulonSystem() {
        return view('maps.nebulonSystem');
    }

    public function nebulonSystem3d() {
        return view('maps.nebulonSystem3d');
    }
}
