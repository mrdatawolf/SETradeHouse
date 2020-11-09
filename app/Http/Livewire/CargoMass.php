<?php namespace App\Http\Livewire;

use Livewire\Component;

class CargoMass extends Component
{
    public $cargoMass = 0;

    public function render()
    {
        return view('livewire.cargo-mass');
    }

    public function cargoMassChanged()
    {
        $this->emit('cargoMassChanged', $this->cargoMass);
    }
}
