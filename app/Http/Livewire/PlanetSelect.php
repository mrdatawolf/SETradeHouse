<?php namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Planets;
use \Session;

class PlanetSelect extends Component
{
    public $planets;
    public $planet;
    public $planetId;
    public $serverId;
    public $worldId;
    public $gravity;
    protected $listeners = ['planetChanged'];

    public function mount() {
        $this->gatherServerId();
        $this->gatherWorldId();
        $this->planets = Planets::where('world_id', $this->worldId)->where('server_id', $this->serverId)->orderBy('title')->get();
        $this->planetId = $this->planets->first()->id;
        $this->planetIdChanged();
    }

    public function render()
    {
        return view('livewire.planet-select');
    }

    public function planetIdChanged() {
        $this->planet = Planets::find($this->planetId);
        $this->gravity = $this->planet->surface_gravity;
        $this->emit('planetIdChanged', $this->planetId);
        $this->emit('updatedGravity', $this->gravity);
    }


    private function gatherServerId() {
        $serverId = 1;
        if(! empty(Session::get('serverId'))) {
            $serverId = (int) Session::get('serverId');
        }

        $this->serverId = $serverId;
    }


    private function gatherWorldId() {
        $worldId = 1;
        if(! empty(Session::get('worldId'))) {
            $worldId = (int) Session::get('worldId');
        }

        $this->worldId = $worldId;
    }
}
