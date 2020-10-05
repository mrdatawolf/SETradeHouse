<?php

namespace App\Http\Livewire\Transactions\Builder;

use Livewire\Component;

class CsvArea extends Component
{
    protected $listeners = ['updatedModifier', 'updatedAmount'];
    public $goods = [];
    public $goodBaseValue = 0;
    public $modifier = 1;
    public $amount = 0;
    public $pricePer = 0;
    public $transactionType = '';
    public $textareaCsv = '';

    public function updatedAmount($amount) {
        $this->amount = $amount;
    }

    public function updatedModifier($modifier) {
        $this->modifier = $modifier;
        foreach($this->goods as $good) {
            $this->goodBaseValue = $good->getScarcityAdjustedValue();
            $this->pricePer = round($this->goodBaseValue * $this->modifier);
        }
    }

    public function render()
    {
        $this->textareaCsv = '';
        foreach($this->goods as $good) {
            $this->goodBaseValue = $good->getScarcityAdjustedValue();
            $this->pricePer      = round($this->goodBaseValue * $this->modifier);
            $this->textareaCsv   .= $good->se_name . "," . ucfirst($this->transactionType) . ',' . $this->pricePer . ',' . $this->amount . PHP_EOL;
        }

        return view('livewire.transactions.builder.csv-area');
    }
}
