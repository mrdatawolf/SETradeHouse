<?php

namespace App\Http\Livewire\Server;

use Livewire\Component;
use App\Models\Mods as Model;

class Mods extends Component
{

    public $mods = [];

    public function render()
    {
        $serverId = \Auth::user()->server_id;
        $this->mods = Model::where('server_id', $serverId)->get()->toArray();

        return view('livewire.server.mods');
    }
}
