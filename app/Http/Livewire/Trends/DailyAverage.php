<?php

namespace App\Http\Livewire\Trends;

use Livewire\Component;

class DailyAverage extends Component
{
    public $trendDailyAvg;
    public $trendDailyLabels;

    public function render()
    {
        return view('livewire.trends.daily-average');
    }
}
