<?php

namespace App\Http\Livewire\Stocklevels;

use Livewire\Component;

class Npc extends Component
{
    public $stockLevels;

    public function render()
    {
        return view('livewire.stocklevels.npc');
    }
}
