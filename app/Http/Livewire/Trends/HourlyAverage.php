<?php namespace App\Http\Livewire\Trends;

use Livewire\Component;

class HourlyAverage extends Component
{
    public $trendHourlyAvg;
    public $trendHourlyLabels;

    public function render()
    {
        return view('livewire.trends.hourly-average');
    }
}
