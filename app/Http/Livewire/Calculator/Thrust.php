<?php namespace App\Http\Livewire\Calculator;

use App\Models\Planets;
use App\Models\Servers;
use App\Models\Thrusters;
use Livewire\Component;

class Thrust extends Component
{
    public $gravity             = 0;
    public $planetId;
    public $shipSize            = 'small';
    public $dryMass             = 0;
    public $cargoMass           = 0;
    public $cargoMultiplier     = 1;
    public $newtonsRequired     = 0;
    public $gravityAcceleration = 9.81;
    public $thrusters;
    public $thruster;
    public $thrusterSizes       = [];
    public $thrusterTypes       = [];
    public $type;
    public $size;

    protected $listeners = [
        'planetIdChanged',
        'shipSizeChanged',
        'cargoMassChanged',
        'dryMassChanged',
        'updatedShipSize',
        'updatedGravity'
    ];


    public function mount()
    {
        $serverId       = (int)\Session::get('serverId');
        $worldId        = (int)\Session::get('worldId');
        $planets        = Planets::where('world_id', $worldId)->where('server_id', $serverId)->orderBy('title')->get();
        $planet         = $planets->first();
        $this->planetId = $planet->id;
        $server = Servers::find($serverId);

        $this->shipSize            = 'small';
        $this->thrusterSizes       = ['small', ' large'];
        $this->thrusterTypes       = [
            'ion',
            'hydrogen',
            'atmospheric',
            'plasma'
        ];
        $this->gravityAcceleration = 9.81;
        $this->cargoMultiplier     = $server->scaling_modifier;

        $this->planetIdChanged($this->planetId);
        $this->updatedGravity($planet->surface_gravity);
        $this->updatedShipSize('small');
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


    public function updatedGravity($value)
    {
        $this->gravity = (int)$value;
        $this->calculateNewtonsRequired();
    }


    public function updatedShipSize($size)
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

    public function gravityChanged()
    {
        $this->calculateNewtonsRequired();
        $this->gatherThrusterData();
    }

    public function calculateNewtonsRequired()
    {
        $this->newtonsRequired = $this->gravity * ($this->dryMass + ($this->cargoMass / $this->cargoMultiplier)) * $this->gravityAcceleration;
    }

    private function largeReactorsRequired() {
        return 1;
    }

    private function smallReactorsRequired() {
        return 1;
    }

    private function naquadahReactorsRequired() {
        return 1;
    }

    private function gatherThrusterData() {
        $this->thrusters = [];
        foreach($this->thrusterTypes as $type) {
            $this->type = $type;
            foreach($this->thrusterSizes as $size) {
                $this->size     = $size;
                $this->thruster = [
                    'type'                   => $this->type,
                    'size'                   => $this->size,
                    'required'               => $this->thrustersRequired(),
                    'largeReactorsNeeded'    => $this->largeReactorsRequired(),
                    'smallReactorsNeeded'    => $this->smallReactorsRequired(),
                    'naquadahReactorsNeeded' => $this->naquadahReactorsRequired(),
                ];

                $this->thrusters[] = $this->thruster;
            }
        }
    }

    private function thrustersRequired() {
        $thruster = Thrusters::where('ship_size', $this->shipSize)->where('type', $this->type)->where('size', $this->size)->first();
        if($this->newtonsRequired < 1 || empty($thruster)) {
            return 0;
        } else {
            return ceil($this->newtonsRequired / $thruster->newtons);
        }
    }
}
