<?php

namespace App\Http\Livewire\Stores\Worlds;

use App\Models\Worlds;
use Livewire\Component;

class SelectWorld extends Component
{
    public $serverId = 1; //passed in
    public $worldId = 1; //passed in
    public $onlyPlanets = false; //passed in
    public $worlds;

    public function mount()
    {
        $this->worlds    = ($this->onlyPlanets) ?  Worlds::where(['server_id' =>$this->serverId, 'type_id' => 1])->get() : Worlds::where('server_id',$this->serverId)->get();
    }
    public function render()
    {

        return view('livewire.stores.worlds.select-world');
    }

    public function updatedWorldId() {
        \Session::put('worldId',$this->worldId);
        $this->emit('worldChanged', $this->worldId);
    }
}
