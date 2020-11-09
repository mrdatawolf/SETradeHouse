<?php

namespace App\Http\Livewire\Calculator\Ship\Thrusters\Table;

use Livewire\Component;

class Cell extends Component
{
    public $value;

    public function mount($value) {
        $this->value = $value;
    }

    public function render()
    {
        return view('livewire.calculator.ship.small.thrusters.table.cell');
    }
}
