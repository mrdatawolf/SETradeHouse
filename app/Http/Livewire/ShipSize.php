<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ShipSize extends Component
{
    public $shipSize = 'small';

    public function render()
    {
        $this->updatedShipSize();
        return view('livewire.ship-size');
    }

    public function updatedShipSize() {
        $this->emit('updatedShipSize', $this->shipSize);
    }
}
