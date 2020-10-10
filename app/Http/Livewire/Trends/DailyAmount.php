<?php

namespace App\Http\Livewire\Trends;

use Livewire\Component;

class DailyAmount extends Component
{
    public $trendDailyAvailable;
    public $trendDailyLabels;

    public function render()
    {
        return view('livewire.trends.daily-amount');
    }
}
