<?php

namespace App\Http\Livewire\Server;

use Livewire\Component;
use App\Models\Rules as Model;

class Rules extends Component
{

    public $rulesMessages = [];

    public function render()
    {
        $serverId = \Auth::user()->server_id;
        foreach(Model::where('server_id', $serverId)->get() as $message) {
            $this->rulesMessages[] = $message->message;
        }

        return view('livewire.server.rules');
    }
}
