<?php

namespace App\Http\Livewire\Server;

use Livewire\Component;
use App\Models\Welcome as WelcomeModel;

class Welcome extends Component
{

    public $welcomeMessages = [];

    public function render()
    {
        $serverId = \Auth::user()->server_id;
        foreach(WelcomeModel::where('server_id', $serverId)->get() as $welcomeMessage) {
            $this->welcomeMessages[] = $welcomeMessage->message;
        }

        return view('livewire.server.welcome');
    }
}
