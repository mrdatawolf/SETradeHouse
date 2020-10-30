<?php namespace App\Http\Traits;

use App\Models\NpcStorageValues;
use Carbon\Carbon;
use App\Models\Transactions;

trait Staleness
{
    protected $warningMaximum   = 60;
    protected $errorMaximum     = 120;

    public function generalStaleness() {
        $syncStaleObject = $this->syncStaleness();
        $dbStaleObject = $this->dbStaleness();

        $dbStaleness      = $dbStaleObject->minutes;
        $syncStaleness    = $syncStaleObject->minutes;

        $generalStaleness = 0;
        if ($dbStaleness > $generalStaleness) {
            $generalStaleness = (int)$dbStaleness;
        }
        if ($syncStaleness > $generalStaleness) {
            $generalStaleness = (int)$syncStaleness;
        }

        return (object) ['class' => $this->getClass($generalStaleness), 'minutes' => $generalStaleness];
    }

    public function dbStaleness() {
        $npcStorageValue        = NpcStorageValues::latest('origin_timestamp')->first();
        $newestDbRecord   = (empty($npcStorageValue->origin_timestamp)) ? 'N/A'
            : $npcStorageValue->origin_timestamp.' -7';
        $dbCarbonDate           = Carbon::createFromFormat('Y-m-d H:i:s', $npcStorageValue->origin_timestamp,
            'America/Los_Angeles');
        $dbStaleness      = (int)Carbon::now()->diffInMinutes($dbCarbonDate);

        return (object) ['class' => $this->getClass($dbStaleness), 'minutes' => $dbStaleness, 'newest' => $newestDbRecord];
    }

    public function syncStaleness() {
        $transaction            = Transactions::latest('updated_at')->first();
        $newestSyncRecord = (empty($transaction->updated_at)) ? 'N/A'
            : $transaction->updated_at->toDateTimeString().' +0';
        $npcCarbonDate          = Carbon::createFromFormat('Y-m-d H:i:s', $transaction->updated_at);
        $syncStaleness    = (int)Carbon::now()->diffInMinutes($npcCarbonDate);

        return (object) ['class' => $this->getClass($syncStaleness), 'minutes' => $syncStaleness, 'newest' => $newestSyncRecord];
    }


    /**
     * @param $minutes
     *
     * @return string
     */
    private function getClass($minutes) {
        $syncStaleClass = '';
        if ($minutes > $this->errorMaximum) {
            $syncStaleClass = 'staleError';
        } elseif ($minutes > $this->warningMaximum) {
            $syncStaleClass = 'staleWarn';
        }

        return $syncStaleClass;
    }
}
