<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Trends;
use Illuminate\Http\Request;

class TrendsController extends Controller
{
    public function index() {
        $trends = Trends::all();

        return response()->json([
            'trends' => $trends
        ]);
    }
}
