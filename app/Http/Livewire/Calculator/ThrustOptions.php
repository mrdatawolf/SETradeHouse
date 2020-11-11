<?php namespace App\Http\Livewire\Calculator;

use App\Models\Planets;
use Livewire\Component;
use \Session;

class ThrustOptions extends Component
{


    public $shipSize = 'small';
    public $thrusterSizes       = [];
    public $thrusterSize;
    public $thrusterTypes;
    public $thrusterType;

    public function mount() {
        $this->gatherServerId();
        $this->gatherWorldId();
        $this->thrusterSizes       = ['small', 'large'];
        $this->thrusterSize = 'small';
        $this->thrusterTypes       = [
            'ion',
            'hydrogen',
            'atmospheric',
            'plasma'
        ];
    }


    public function render()
    {
        return view('livewire.calculator.thrust-options');
    }


    public function shipSizeChanged() {
        $this->emit('shipSizeChanged', $this->shipSize);
    }


    public function thrusterSizeChanged()
    {
        $this->emit('thrusterSizeChanged', $this->thrusterSize);
    }


    public function thrusterTypeChanged()
    {
        $this->emit('thrusterTypeChanged', $this->thrusterType);
    }


    private function gatherServerId() {
        $serverId = 1;
        if(! empty(Session::get('serverId'))) {
            $serverId = (int) Session::get('serverId');
        }

        $this->serverId = $serverId;
    }


    private function gatherWorldId() {
        $worldId = 1;
        if(! empty(Session::get('worldId'))) {
            $worldId = (int) Session::get('worldId');
        }

        $this->worldId = $worldId;
    }
}
