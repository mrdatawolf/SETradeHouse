<?php namespace App\Http\Livewire\Trends;

use Livewire\Component;

class HourlyAmount extends Component
{
    public $trendHourlyAvailable;
    public $trendHourlyLabels;

    public function render()
    {
        return view('livewire.trends.hourly-amount');
    }
}
