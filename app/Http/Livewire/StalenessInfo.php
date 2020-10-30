<?php namespace App\Http\Livewire;

use Livewire\Component;
use App\Http\Traits\Staleness;

class StalenessInfo extends Component
{
    use Staleness;

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
        $syncObject = $this->syncStaleness();
        $dbSyncObject = $this->dbStaleness();
        $generalSyncObject = $this->generalStaleness();
        $this->syncStaleness = $syncObject->minutes;
        $this->syncStaleClass = $syncObject->class;
        $this->dbStaleness = $dbSyncObject->minutes;
        $this->dbStaleClass = $dbSyncObject->class;
        $this->newestDbRecord = $dbSyncObject->newest;
        $this->newestSyncRecord = $syncObject->newest;
        $this->generalStaleness = $generalSyncObject->minutes;
        $this->generalStaleClass = $generalSyncObject->class;



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
