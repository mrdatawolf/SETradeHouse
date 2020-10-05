<?php

namespace App\Http\Livewire\Transactions\Builder;

use Livewire\Component;

class RowAmount extends Component
{
    protected $listeners = ['updatedAmount'];
    public $amount;

    public function updatedAmount($amount) {
        $this->amount = $amount;
    }
    public function render()
    {
        return view('livewire.transactions.builder.row-amount');
    }
}
