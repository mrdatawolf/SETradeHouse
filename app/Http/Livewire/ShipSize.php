<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ShipSize extends Component
{
    public $shipSize = 'small';

    public function render()
    {
        return view('livewire.ship-size');
    }

    public function shipSizeChanged() {
        $this->emit('shipSizeChanged', $this->shipSize);
    }
}
