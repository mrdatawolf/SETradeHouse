<?php

namespace App\Http\Livewire\Server;

use Livewire\Component;
use App\Models\Notes as Model;

class Notes extends Component
{

    public $notes = [];

    public function render()
    {
        $serverId = \Auth::user()->server_id;
        foreach(Model::where('server_id', $serverId)->get() as $message) {
            $this->notes[] = $message->message;
        }

        return view('livewire.server.notes');
    }
}
