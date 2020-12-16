<?php

namespace App\Http\Livewire\Server;

use Livewire\Component;
use App\Models\Gps as Model;

class Gps extends Component
{

    public $gpsMessages = [];

    public function render()
    {
        $serverId = \Auth::user()->server_id;
        $this->gpsMessages = Model::where('server_id', $serverId)->get()->toArray();

        return view('livewire.server.gps');
    }
}
