<?php namespace App\Http\Livewire;

use App\Http\Traits\Staleness;
use Livewire\Component;

class ActiveServer extends Component
{
    use Staleness;
    public $generalStaleClass;

    public function render()
    {
        $generalSyncObject = $this->generalStaleness();
        $this->generalStaleClass = $generalSyncObject->class;

        return view('livewire.active-server');
    }
}
