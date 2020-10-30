<?php

namespace App\Http\Livewire\Server\Worlds;

use App\Http\Traits\worldInfo;
use App\Models\Servers;
use Livewire\Component;

class StatusTable extends Component
{
    use worldInfo;

    public $serverId;
    public $server;
    public $rarity;
    public $ratio;
    public $rarityPercentages;
    public $worldsCount;


    public function render()
    {
        $this->serverId          = \Session::get('serverId');
        $this->server            = Servers::find($this->serverId);
        $this->worldsCount       = $this->server->worlds()->count();
        $this->rarity            = $this->server->getWorldsRarityTotals();
        $this->ratio             = $this->server->ratio;
        $this->rarityPercentages = $this->getRarityPercentages();

        return view('livewire.server.worlds.status-table');
    }
}
