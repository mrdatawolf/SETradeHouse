<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ThrusterSize extends Component
{
    public $thrusterSizes       = [];
    public $thrusterSize;

    public function  mount() {
        $this->thrusterSizes       = ['small', 'large'];
        $this->thrusterSize = 'small';
    }
    public function render()
    {
        return view('livewire.thruster-size');
    }

    public function thrusterSizeChanged()
    {
        $this->emit('thrusterSizeChanged', $this->thrusterSize);
    }
}
