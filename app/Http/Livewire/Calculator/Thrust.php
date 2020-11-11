<?php namespace App\Http\Livewire\Calculator;

use App\Models\Planets;
use App\Models\Reactors;
use App\Models\Servers;
use App\Models\Thrusters;
use Livewire\Component;
use \Session;

class Thrust extends Component
{
    public $gravity                        = 0;
    public $serverId;
    public $worldId;
    public $planetId;
    public $planetName                     = '';
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

    public $smallReactor;
    public $largeReactor;
    public $naquadahReactor;
    public $numberThrustersRequired;
    public $numberLargeReactorsRequired;
    public $numberSmallReactorsRequired;
    public $numberSpecialReactorsRequired;

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
        $this->gatherServerId();
        $this->gatherWorldId();
        $planets        = Planets::where('world_id', $this->worldId)->where('server_id', $this->serverId)->orderBy('title')->get();
        $planet         = $planets->first();
        $this->planetId = $planet->id;
        $this->planetName = $planet->title;
        $server         = Servers::find($this->serverId);

        $this->shipSize                       = 'small';
        $this->thrusterType                   = 'ion';
        $this->thrusterSize                   = 'small';
        $this->numberThrustersRequired        = 0;
        $this->numberLargeReactorsRequired    = 0;
        $this->numberSmallReactorsRequired    = 0;
        $this->numberSpecialReactorsRequired  = 0;

        $this->gravityAcceleration = 9.81;
        $this->cargoMultiplier     = $server->scaling_modifier;

        $this->planetIdChanged($this->planetId);
        $this->gravityChanged($planet->surface_gravity);
        $this->cargoMassChanged(0);
        $this->dryMassChanged(0);
        $this->calculateNewtonsRequired();
        $this->gatherThrusterData();
        $this->gatherReactorData();
    }


    public function render()
    {
        $this->gatherThrusterData();
        $this->gatherReactorData();

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
        $this->gatherReactorData();
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
        $this->gatherReactorData();
    }


    public function dryMassChanged($value)
    {
        $this->dryMass = (int)$value;
        $this->calculateNewtonsRequired();
        $this->gatherThrusterData();
        $this->gatherReactorData();
    }


    public function thrusterSizeChanged($size)
    {
        $this->thrusterSize = $size;
        $this->gatherThrusterData();
        $this->gatherReactorData();
    }


    public function thrusterTypeChanged($type)
    {
        $this->thrusterType = $type;
        $this->gatherThrusterData();
        $this->gatherReactorData();
    }


    public function calculateNewtonsRequired()
    {
        $this->newtonsRequired = $this->gravity * ($this->dryMass + ($this->cargoMass / $this->cargoMultiplier)) * $this->gravityAcceleration;
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

    private function largeReactorsRequired()
    {
        $this->largeReactor = Reactors::where('size', 'large')->where('type', 'normal')->where('ship_size', $this->shipSize)->first();
        $this->numberLargeReactorsRequired = ceil($this->numberThrustersRequired*($this->thruster->power_draw/$this->largeReactor->watts));
    }


    private function smallReactorsRequired()
    {
        $this->smallReactor = Reactors::where('size', 'small')->where('type', 'normal')->where('ship_size', $this->shipSize)->first();
        $this->numberSmallReactorsRequired = ceil($this->numberThrustersRequired*($this->thruster->power_draw/$this->smallReactor->watts));
    }


    private function specialReactorsRequired()
    {
        $this->naquadahReactor = Reactors::where('size', 'large')->where('type', 'normal')->where('ship_size', $this->shipSize)->first();
        $this->numberSpecialReactorsRequired = ceil($this->numberThrustersRequired*($this->thruster->power_draw/$this->smallReactor->watts));
    }


    private function gatherThrusterData()
    {
        $this->numberThrustersRequired        = $this->thrustersRequired();
    }


    private function gatherReactorData() {
        $this->smallReactorsRequired();
        $this->largeReactorsRequired();
        $this->specialReactorsRequired();
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
            case 'atomospheric' :
                $adjustment = $this->atmosphericPlanetAdjustment;
                break;
            default :
                $adjustment = 1;
            }

        return $this->thruster->newtons * $adjustment;
    }
}
