<?php namespace App\Http\Livewire\Calculator;

use App\Models\Planets;
use App\Models\Worlds;
use Livewire\Component;
use \Session;

class WeightOptions extends Component
{
    public $planets;
    public $planet;
    public $planetId;
    public $serverId;
    public $worldId;
    public $gravity;
    public $cargoMass = 0;
    public $dryMass = 0;

    protected $listeners = ['planetChanged','worldChanged'];

    public function mount() {
        $this->gatherServerId();
        $this->gatherWorldId();
        $this->gatherPlanets();
    }

    public function render()
    {
        return view('livewire.calculator.weight-options');
    }


    public function gatherPlanets() {
        $this->planets = Planets::where('world_id', $this->worldId)->where('server_id', $this->serverId)->orderBy('id')->get();
        $this->planetId = $this->planets->first()->id;
        $this->planetIdChanged();
    }

    public function planetIdChanged() {
        $this->planet = Planets::find($this->planetId);
        $this->gravity = $this->planet->surface_gravity;
        $this->emit('planetIdChanged', $this->planetId);
    }


    public function dryMassChanged()
    {
        $this->emit('dryMassChanged', $this->dryMass);
    }

    public function cargoMassChanged()
    {
        $this->emit('cargoMassChanged', $this->cargoMass);
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

    public function worldChanged($worldId) {
        $this->worldId = $worldId;
        $world = Worlds::find((int)$worldId);
        if($world->type_id == 1) {
            $this->gatherPlanets();
        }
    }
}
