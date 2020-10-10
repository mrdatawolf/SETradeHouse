<?php namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\NpcStorageValues;
use Carbon\Carbon;
use App\Models\Transactions;

class StalenessInfo extends Component
{
    public $syncStaleness;
    public $syncStaleClass;
    public $dbStaleness;
    public $dbStaleClass;
    public $generalStaleness;
    public $generalStaleClass;
    public $newestDbRecord;
    public $newestSyncRecord;

    public function render()
    {
        $warningMaximum = 60;
        $errorMaximum = 120;

        $npcStorageValue        = NpcStorageValues::latest('origin_timestamp')->first();
        $this->newestDbRecord   = (empty($npcStorageValue->origin_timestamp)) ? 'N/A'
            : $npcStorageValue->origin_timestamp.' -7';
        $dbCarbonDate           = Carbon::createFromFormat('Y-m-d H:i:s', $npcStorageValue->origin_timestamp,
            'America/Los_Angeles');
        $this->dbStaleness      = (int)Carbon::now()->diffInMinutes($dbCarbonDate);
        $transaction            = Transactions::latest('updated_at')->first();
        $this->newestSyncRecord = (empty($transaction->updated_at)) ? 'N/A'
            : $transaction->updated_at->toDateTimeString().' +0';
        $npcCarbonDate          = Carbon::createFromFormat('Y-m-d H:i:s', $transaction->updated_at);
        $this->syncStaleness    = (int)Carbon::now()->diffInMinutes($npcCarbonDate);
        $this->generalStaleness = 0;
        if ($this->dbStaleness > $this->generalStaleness) {
            $this->generalStaleness = (int)$this->dbStaleness;
        }
        if ($this->syncStaleness > $this->generalStaleness) {
            $this->generalStaleness = (int)$this->syncStaleness;
        }
        $this->generalStaleClass = '';
        if ($this->generalStaleness > $errorMaximum) {
            $this->generalStaleClass = 'staleError';
        } elseif ($this->generalStaleness > $warningMaximum) {
            $this->generalStaleClass = 'staleWarn';
        }
        $this->dbStaleClass = '';
        if ($this->dbStaleness > $errorMaximum) {
            $this->dbStaleClass = 'staleError';
        } elseif ($this->dbStaleness > $warningMaximum) {
            $this->dbStaleClass = 'staleWarn';
        }
        $this->syncStaleClass = '';
        if ($this->syncStaleness > $errorMaximum) {
            $this->syncStaleClass = 'staleError';
        } elseif ($this->syncStaleness > $warningMaximum) {
            $this->syncStaleClass = 'staleWarn';
        }

        return view('livewire.staleness-info', [
            'syncStaleness' => $this->syncStaleness,
            'syncStaleClass' => $this->syncStaleClass,
            'dbStaleness' => $this->dbStaleness,
            'dbStaleClass' => $this->dbStaleClass,
            'generalStaleness' => $this->generalStaleness,
            'generalStaleClass' => $this->generalStaleClass,
            'newestDbRecord' => $this->newestDbRecord,
            'newestSyncRecord' => $this->newestSyncRecord
        ]);
    }
}
