<?php

namespace App\Http\Livewire\Transactions\Builder;

use Livewire\Component;

class RowValue extends Component
{
    protected $listeners = ['updatedModifier'];
    public $good;
    public $goodBaseValue = 0;
    public $modifier = 1;
    public $pricePer = 0;

    public function updatedModifier($modifier) {
        $this->modifier = $modifier;
        $this->pricePer = round($this->good->getScarcityAdjustedValue()*$this->modifier);
    }

    public function render()
    {
        $this->goodBaseValue = $this->good->getScarcityAdjustedValue();
        $this->pricePer = round($this->goodBaseValue*$this->modifier);

        return view('livewire.transactions.builder.row-value');
    }
}
