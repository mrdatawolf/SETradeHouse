<?php

namespace App\Http\Livewire\Server;

use Livewire\Component;
use App\Models\Information as Model;

class Information extends Component
{

    public $informationMessages = [];

    public function render()
    {
        $serverId = \Auth::user()->server_id;
        foreach(Model::where('server_id', $serverId)->get() as $message) {
            $this->informationMessages[] = $message->message;
        }

        return view('livewire.server.information');
    }
}
