<?php

namespace App\Http\Livewire\Server;

use Livewire\Component;
use App\Models\Commands as Model;

class Commands extends Component
{

    public $commands = [];

    public function render()
    {
        $serverId = \Auth::user()->server_id;
        $this->commands = Model::where('server_id', $serverId)->get()->toArray();

        return view('livewire.server.commands');
    }
}
