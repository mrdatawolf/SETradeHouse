<?php namespace App\Http\Livewire;

use App\Models\Planets;
use Livewire\Component;

class ThrustValuesCheck extends Component
{
    protected $listeners = ['planetIdChanged', 'shipSizeChanged', 'cargoMassChanged', 'dryMassChanged'];




    public function render()
    {
        return view('livewire.thrust-values-check');
    }



}
