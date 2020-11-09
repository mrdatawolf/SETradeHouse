<?php

namespace App\Http\Livewire;

use Livewire\Component;

class DryMass extends Component
{
    public $dryMass = 0;

    public function render()
    {
        return view('livewire.dry-mass');
    }

    public function dryMassChanged()
    {
        $this->emit('dryMassChanged', $this->dryMass);
    }
}
