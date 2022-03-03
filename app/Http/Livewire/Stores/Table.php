<?php

namespace App\Http\Livewire\Stores;

use Livewire\Component;

class Table extends Component
{
    public $goodRow;
    public $goodType;

    public function mount()
    {
        //stuff
    }


    public function render()
    {
        return view('livewire.stores.table');
    }
}
