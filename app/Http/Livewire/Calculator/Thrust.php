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
    public $planet;

    public $shipSize                       = '';
    public $dryMass                        = 0;
    public $cargoMass                      = 0;
    public $cargoMultiplier                = 1;
    public $userAppliedNewtons             = 0;
    public $newtonsRequired                = 0;
    public $totalNewtonsApplied            = 0;
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
    public $usrSetSmallIon;
    public $usrSetLargeIon;
    public $usrSetSmallHydrogen;
    public $usrSetLargeHydrogen;
    public $usrSetSmallAtmospheric;
    public $usrSetLargeAtmospheric;
    public $usrSetSmallPlasma;
    public $usrSetLargePlasma;

    public $ionMinimumPlanetAdjustment     = .2;
    public $plasmaMinimumPlanetAdjustment  = .6;
    public $atmosphericPlanetAdjustment    = .87;

    public $metersPerSecond;
    public $baseAcceleration;
    public $totalMass;

    protected $listeners = [
        'planetIdChanged',
        'shipSizeChanged',
        'thrusterSizeChanged',
        'thrusterTypeChanged',
        'cargoMassChanged',
        'dryMassChanged',
        'shipSizeChanged',
        'gravityChanged',
        'usrSetSmallIonChanged'
    ];


    public function mount()
    {
        $this->gatherServerId();
        $this->gatherWorldId();
        $this->planet       = Planets::where('world_id', $this->worldId)->where('server_id', $this->serverId)->orderBy('id')->first();
        $this->planetId     = $this->planet->id;
        $this->planetName   = $this->planet->title;
        $server             = Servers::find($this->serverId);

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
        $this->gravityChanged($this->planet->surface_gravity);
        $this->cargoMassChanged(0);
        $this->dryMassChanged(0);
        $this->calculateNewtons();
        $this->resetUserThrusters();
        $this->gatherThrusterData();
        $this->gatherReactorData();
        $this->gatherMetersPerSecond();
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
        $this->planet = Planets::find($id);
        $this->gravityChanged($this->planet->surface_gravity);
    }


    public function gravityChanged($value)
    {
        $this->gravity = (double) $value;
        $this->calculateNewtons();
        $this->gatherThrusterData();
        $this->gatherReactorData();
    }


    public function shipSizeChanged($size)
    {
        $this->shipSize = $size;
    }


    public function cargoMassChanged($value)
    {
        $this->cargoMass = (int) $value;
        $this->calculateNewtons();
        $this->gatherThrusterData();
        $this->gatherReactorData();
    }


    public function dryMassChanged($value)
    {
        $this->dryMass = (int) $value;
        $this->calculateNewtons();
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


    public function usrThrustChange() {
        $this->calculateUserAppliedNewtons();
        $this->calculateNewtons();
        $this->gatherThrusterData();
        $this->gatherReactorData();
    }


    public function calculateNewtons() {
        $this->calculateNewtonsRequired();
        $this->calculateTotalNewtonsApplied();
        $this->calculateBaseAcceleration();
    }

    public function calculateNewtonsRequired()
    {
        $this->totalMass = $this->dryMass + ($this->cargoMass / $this->cargoMultiplier);
        $this->newtonsRequired = $this->gravity * ($this->totalMass) * $this->gravityAcceleration;
    }

    public function calculateBaseAcceleration() {
        $this->baseAcceleration = ($this->totalMass === 0 || $this->gravity === 0) ? 0 : $this->totalNewtonsApplied/$this->totalMass*$this->gravity;
    }

    public function calculateTotalNewtonsApplied() {
        $this->totalNewtonsApplied = ($this->newtonsRequired > $this->userAppliedNewtons) ? $this->newtonsRequired : $this->userAppliedNewtons;
    }

    public function calculateUserAppliedNewtons() {
        $adjustedNewtonsOfThrust = 0;
        if($this->usrSetSmallIon > 0) {
            $thruster = Thrusters::where('ship_size', $this->shipSize)
                                       ->where('type', 'ion')
                                       ->where('size', 'small')
                                       ->first();
            $adjustedNewtonsOfThrust += $this->usrSetSmallIon * $this->adjustThrusterNewtonOutput($thruster);
        }
        if($this->usrSetLargeIon > 0) {
            $thruster = Thrusters::where('ship_size', $this->shipSize)
                                 ->where('type', 'ion')
                                 ->where('size', 'large')
                                 ->first();
            $adjustedNewtonsOfThrust += $this->usrSetLargeIon * $this->adjustThrusterNewtonOutput($thruster);
        }
        if($this->usrSetSmallHydrogen > 0) {
            $thruster = Thrusters::where('ship_size', $this->shipSize)
                                 ->where('type', 'hydrogen')
                                 ->where('size', 'small')
                                 ->first();
            $adjustedNewtonsOfThrust += $this->usrSetSmallHydrogen * $this->adjustThrusterNewtonOutput($thruster);
        }
        if($this->usrSetLargeHydrogen > 0) {
            $thruster = Thrusters::where('ship_size', $this->shipSize)
                                 ->where('type', 'hydrogen')
                                 ->where('size', 'large')
                                 ->first();
            $adjustedNewtonsOfThrust += $this->usrSetLargeHydrogen * $this->adjustThrusterNewtonOutput($thruster);
        }
        if($this->usrSetSmallAtmospheric > 0) {
            $thruster = Thrusters::where('ship_size', $this->shipSize)
                                 ->where('type', 'atmospheric')
                                 ->where('size', 'small')
                                 ->first();
            $adjustedNewtonsOfThrust += $this->usrSetSmallAtmospheric * $this->adjustThrusterNewtonOutput($thruster);
        }
        if($this->usrSetLargeAtmospheric > 0) {
            $thruster = Thrusters::where('ship_size', $this->shipSize)
                                 ->where('type', 'atmospheric')
                                 ->where('size', 'large')
                                 ->first();
            $adjustedNewtonsOfThrust += $this->usrSetLargeAtmospheric * $this->adjustThrusterNewtonOutput($thruster);
        }
        if($this->usrSetSmallPlasma > 0) {
            $thruster = Thrusters::where('ship_size', $this->shipSize)
                                 ->where('type', 'plasma')
                                 ->where('size', 'small')
                                 ->first();
            $adjustedNewtonsOfThrust += $this->usrSetSmallPlasma * $this->adjustThrusterNewtonOutput($thruster);
        }
        if($this->usrSetLargePlasma > 0) {
            $thruster = Thrusters::where('ship_size', $this->shipSize)
                                 ->where('type', 'plasma')
                                 ->where('size', 'large')
                                 ->first();
            $adjustedNewtonsOfThrust += $this->usrSetLargePlasma * $this->adjustThrusterNewtonOutput($thruster);
        }

        $this->userAppliedNewtons = $adjustedNewtonsOfThrust;
    }


    private function resetUserThrusters() {
        $this->usrSetSmallIon                = 0;
        $this->usrSetLargeIon                = 0;
        $this->usrSetSmallHydrogen           = 0;
        $this->usrSetLargeHydrogen           = 0;
        $this->usrSetSmallAtmospheric        = 0;
        $this->usrSetLargeAtmospheric        = 0;
        $this->usrSetSmallPlasma             = 0;
        $this->usrSetLargePlasma             = 0;
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
        $this->numberThrustersRequired = $this->thrustersRequired();
        $this->gatherMetersPerSecond();
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
        $adjustedNewtonsOfThrust = $this->adjustThrusterNewtonOutput($this->thruster);
        $newtonsLeft = $this->newtonsRequired - $this->userAppliedNewtons;
        if ($newtonsLeft < 1 || $adjustedNewtonsOfThrust < 1) {
            return 0;
        } else {
            return ceil($newtonsLeft / $adjustedNewtonsOfThrust);
        }
    }


    private function adjustThrusterNewtonOutput($thruster) {
        if(empty($thruster)) {
            return 0;
        }
        switch($thruster->type) {
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

        return $thruster->newtons * $adjustment;
    }


    private function gatherMetersPerSecond() {
        $metersPerSecond = ($this->baseAcceleration > 0) ? $this->baseAcceleration : 1;
        $this->metersPerSecond = [
            'ten' => ceil(10/$metersPerSecond) . " s",
            'twentyFive' => ceil(25/$metersPerSecond) . " s",
            'fifty' => ceil(50/$metersPerSecond) . " s",
            'oneHunderedFifty' => ceil(150/$metersPerSecond) . " s",
            'oneHundered' => ceil(100/$metersPerSecond) . " s",
            'twoHunderedFifty' => ceil(250/$metersPerSecond) . " s",
            'fiveHundered' => ceil(500/$metersPerSecond) . " s",
            'thousand' => ceil(1000/$metersPerSecond) . " s",
        ];
    }
}
