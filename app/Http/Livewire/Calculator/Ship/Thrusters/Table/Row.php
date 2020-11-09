<?php

namespace App\Http\Livewire\Calculator\Ship\Thrusters\Table;

use Livewire\Component;

class Row extends Component
{
    public $thruster;

    public function mount($thruster) {
        $this->thruster = $thruster;
    }

    public function render()
    {
        return view('livewire.calculator.ship.thrusters.table.row');
    }
}
