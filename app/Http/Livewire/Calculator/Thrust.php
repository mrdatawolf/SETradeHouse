<?php namespace App\Http\Livewire\Calculator;

use App\Models\Planets;
use App\Models\Servers;
use App\Models\Thrusters;
use Livewire\Component;
use \Session;

class Thrust extends Component
{
    public $gravity                        = 0;
    public $planetId;
    public $shipSize                       = '';
    public $dryMass                        = 0;
    public $cargoMass                      = 0;
    public $cargoMultiplier                = 1;
    public $newtonsRequired                = 0;
    public $gravityAcceleration            = 9.81;
    public $thrusters;
    public $thruster;
    public $thrusterType                   = '';
    public $thrusterSize                   = '';
    public $numberThrustersRequired        = 0;
    public $numberLargeReactorsRequired    = 0;
    public $numberSmallReactorsRequired    = 0;
    public $numberNaquadahReactorsRequired = 0;
    public $ionMinimumPlanetAdjustment     = .2;
    public $plasmaMinimumPlanetAdjustment  = .6;
    public $atmosphericPlanetAdjustment    = .87;

    protected $listeners = [
        'planetIdChanged',
        'shipSizeChanged',
        'thrusterSizeChanged',
        'thrusterTypeChanged',
        'cargoMassChanged',
        'dryMassChanged',
        'shipSizeChanged',
        'gravityChanged'
    ];


    public function mount()
    {
        $serverId       = (int) Session::get('serverId');
        $worldId        = (int) Session::get('worldId');
        $planets        = Planets::where('world_id', $worldId)->where('server_id', $serverId)->orderBy('title')->get();
        $planet         = $planets->first();
        $this->planetId = $planet->id;
        $server         = Servers::find($serverId);

        $this->shipSize                       = 'small';
        $this->thrusterType                   = 'ion';
        $this->thrusterSize                   = 'small';
        $this->numberThrustersRequired        = 0;
        $this->numberLargeReactorsRequired    = 0;
        $this->numberSmallReactorsRequired    = 0;
        $this->numberNaquadahReactorsRequired = 0;

        $this->gravityAcceleration = 9.81;
        $this->cargoMultiplier     = $server->scaling_modifier;

        $this->planetIdChanged($this->planetId);
        $this->gravityChanged($planet->surface_gravity);
        $this->cargoMassChanged(0);
        $this->dryMassChanged(0);
        $this->calculateNewtonsRequired();
        $this->gatherThrusterData();
    }


    public function render()
    {
        $this->gatherThrusterData();

        return view('livewire.calculator.thrust');
    }


    public function planetIdChanged($id)
    {
        $this->planetId = $id;
    }


    public function gravityChanged($value)
    {
        $this->gravity = (int)$value;
        $this->calculateNewtonsRequired();
        $this->gatherThrusterData();
    }


    public function shipSizeChanged($size)
    {
        $this->shipSize = $size;
    }


    public function cargoMassChanged($value)
    {
        $this->cargoMass = (int)$value;
        $this->calculateNewtonsRequired();
        $this->gatherThrusterData();
    }


    public function dryMassChanged($value)
    {
        $this->dryMass = (int)$value;
        $this->calculateNewtonsRequired();
        $this->gatherThrusterData();
    }


    public function thrusterSizeChanged($size)
    {
        $this->thrusterSize = $size;
        $this->gatherThrusterData();
    }


    public function thrusterTypeChanged($type)
    {
        $this->thrusterType = $type;
        $this->gatherThrusterData();
    }


    public function calculateNewtonsRequired()
    {
        $this->newtonsRequired = $this->gravity * ($this->dryMass + ($this->cargoMass / $this->cargoMultiplier)) * $this->gravityAcceleration;
    }


    private function largeReactorsRequired()
    {
        return 1;
    }


    private function smallReactorsRequired()
    {
        return 1;
    }


    private function naquadahReactorsRequired()
    {
        return 1;
    }


    private function gatherThrusterData()
    {
        $this->numberThrustersRequired        = $this->thrustersRequired();
        $this->numberLargeReactorsRequired    = $this->largeReactorsRequired();
        $this->numberSmallReactorsRequired    = $this->smallReactorsRequired();
        $this->numberNaquadahReactorsRequired = $this->naquadahReactorsRequired();
    }


    private function thrustersRequired()
    {
        $this->thruster = Thrusters::where('ship_size', $this->shipSize)
                             ->where('type', $this->thrusterType)
                             ->where('size', $this->thrusterSize)
                             ->first();
        $adjustedNewtonsOfThrust = $this->adjustThrusterNewtonOutput();
        if ($this->newtonsRequired < 1 || $adjustedNewtonsOfThrust < 1) {
            return 0;
        } else {
            return ceil($this->newtonsRequired / $adjustedNewtonsOfThrust);
        }
    }


    private function adjustThrusterNewtonOutput() {
        if(empty($this->thruster)) {
            return 0;
        }
        switch($this->thruster->type) {
            case 'ion' :
                $adjustment = $this->ionMinimumPlanetAdjustment;
                break;
            case 'plasma' :
                $adjustment = $this->plasmaMinimumPlanetAdjustment;
                break;
            default :
                $adjustment = 1;
            }

        return $this->thruster->newtons * $adjustment;
    }
}
