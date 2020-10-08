<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Trends;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TrendsController extends Controller
{
    public function index(Request $request) {
        if(!auth()->user()->tokenCan('read')) {
                       abort(403, 'Unauthorized');
        }


        if(! empty($request)) {
            $transactionTypeId = (empty($request->transactionType) || $request->transactionType === 'order') ? 1 : 2;
            //todo:: these need to be converted to string names... so goodId should be carbon and goodType shoudl be ore.
            $goodTypeId = $request->goodTypeId;
            $goodId = $request->goodId;
            $earliestDate = (empty($request->earliestDate)) ? Carbon::now()->subHours(6) : Carbon::createFromDate($request->earliestDate);

            $trends = Trends::where('transaction_type_id',$transactionTypeId)
                            ->where('good_type_id', $goodTypeId)
                            ->where('good_id',$goodId)->where('dated_at', '>=',$earliestDate)->get();
        } else {
            $trends = Trends::all();
        }

        return response()->json([
            'trends' => $trends
        ]);
    }

    public function show(Request $request) {
        if(!auth()->user()->tokenCan('read')) {
            abort(403, 'Unauthorized');
        }
        return response()->json([]);
    }
}
