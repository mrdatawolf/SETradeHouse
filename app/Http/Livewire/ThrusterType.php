<?php namespace App\Http\Livewire;

use Livewire\Component;

class ThrusterType extends Component
{
    public $thrusterTypes;
    public $thrusterType;

    public function mount() {
        $this->thrusterTypes       = [
            'ion',
            'hydrogen',
            'atmospheric',
            'plasma'
        ];
    }
    public function render() {
        return view('livewire.thruster-type');
    }

    public function thrusterTypeChanged()
    {
        $this->emit('thrusterTypeChanged', $this->thrusterType);
    }
}
