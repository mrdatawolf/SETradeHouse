<?php

namespace App\Http\Livewire\Transactions;

use App\Models\Components;
use App\Models\Ingots;
use App\Models\Ores;
use App\Models\Tools;
use Livewire\Component;

class Builder extends Component
{
    public $amount;
    public $modifier;
    public $goodType;
    public $goods = null;
    public $transactionType;

    public function updatedAmount() {
        $this->emit('updatedAmount', $this->amount);
    }

    public function updatedModifier() {
        $this->emit('updatedModifier', $this->modifier);
    }


    public function render()
    {
        $this->modifier = ($this->transactionType === 'order' ? .95 : 1);
        $this->amount = ($this->transactionType === 'order' ? 100000 : 10000);
        switch($this->goodType) {
            case 'ores':
                $this->goods = Ores::where('se_name', '!=', 'fillme')->get();
                break;
            case 'ingots':
                $this->goods = Ingots::where('se_name', '!=', 'fillme')->get();
                break;
            case 'components':
                $this->goods = Components::where('se_name', '!=', 'fillme')->get();
                break;
            case 'tools':
                $this->goods = Tools::where('se_name', '!=', 'fillme')->get();
                break;
        }

        $goods = $this->goods;
        return view('livewire.transactions.builder', compact('goods'));
    }
}
