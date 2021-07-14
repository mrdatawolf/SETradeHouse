<?php namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\NpcStorageValues;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Transactions;

class DataStatusController extends Controller
{
    public function index()
    {
        if(!auth()->user()->tokenCan('read')) {
            abort(403, 'Unauthorized');
        }
        try {
            $npcStorageValue  = NpcStorageValues::latest('origin_timestamp')->first();
            $newestDbRecord   = (empty($npcStorageValue->origin_timestamp)) ? 'N/A'
                : $npcStorageValue->origin_timestamp.' -7';
            $dbCarbonDate     = Carbon::createFromFormat('Y-m-d H:i:s', $npcStorageValue->origin_timestamp,
                'America/Los_Angeles');
            $dbStaleness      = (int)Carbon::now()->diffInHours($dbCarbonDate);
            $transaction      = Transactions::latest('updated_at')->first();
            $newestSyncRecord = (empty($transaction->updated_at)) ? 'N/A'
                : $transaction->updated_at->toDateTimeString().' +0';
            $npcCarbonDate    = Carbon::createFromFormat('Y-m-d H:i:s', $transaction->updated_at);
            $syncStaleness    = (int)Carbon::now()->diffInHours($npcCarbonDate);
            $generalStaleness = 0;
            if ($dbStaleness > $generalStaleness) {
                $generalStaleness = (int)$dbStaleness;
            }
            if ($syncStaleness > $generalStaleness) {
                $generalStaleness = (int)$syncStaleness;
            }

            return response()->json([
                'newestDbRecord'   => $newestDbRecord,
                'newestSyncRecord' => $newestSyncRecord,
                'generalStaleness' => $generalStaleness,
                'dbStaleness'      => $dbStaleness,
                'syncStaleness'    => $syncStaleness
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage(), 'line' => $e->getLine()]);
        }
    }

    public function show() {
        if(!auth()->user()->tokenCan('read')) {
            abort(403, 'Unauthorized');
        }

        return response()->json(['Nothing to see here']);
    }

    public function import() {
        if(!auth()->user()->tokenCan('read')) {
            abort(403, 'Unauthorized');
        }
        $npcStorageValue  = NpcStorageValues::latest('origin_timestamp')->first();
        $newestDbRecord   = (empty($npcStorageValue->origin_timestamp)) ? 'N/A'
            : $npcStorageValue->origin_timestamp.' -7';
        $dbCarbonDate     = Carbon::createFromFormat('Y-m-d H:i:s', $npcStorageValue->origin_timestamp,
            'America/Los_Angeles');
        $dbStaleness      = (int)Carbon::now()->diffInHours($dbCarbonDate);

        return response()->json([
            'newestDbRecord'   => $newestDbRecord,
            'dbStaleness'      => $dbStaleness,
        ]);
    }

    public function sync() {
        if(!auth()->user()->tokenCan('read')) {
            abort(403, 'Unauthorized');
        }
        $transaction      = Transactions::latest('updated_at')->first();
        $newestSyncRecord = (empty($transaction->updated_at)) ? 'N/A'
            : $transaction->updated_at->toDateTimeString().' +0';
        $npcCarbonDate    = Carbon::createFromFormat('Y-m-d H:i:s', $transaction->updated_at);
        $syncStaleness    = (int)Carbon::now()->diffInHours($npcCarbonDate);

        return response()->json([
            'newestSyncRecord' => $newestSyncRecord,
            'syncStaleness'    => $syncStaleness
        ]);
    }
}
