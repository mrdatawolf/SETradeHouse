<?php namespace Core;

use DB\dbClass;

class Clusters extends dbClass
{
    public $id;
    public $clusterId;
    public $totalServers = 0;
    public $totalPlanets = 0;
    public $totalAsteroids = 0;

    protected $data;
    protected $servers;
    protected $scalingModifier;
    protected $serverIds;
    protected $oreIds;
    protected $ores;
    protected $ingotIds;
    protected $ingots;
    protected $componentIds;
    protected $components;



    public $foundationalOreId;
    public $foundationalIngotId;
    public $foundationOreData;
    public $foundationIngotData;
    public $foundationOrePerIngot;
    public $planetIds = [];
    public $asteroidIds = [];

    private $table = 'clusters';

    public function __construct($clusterId)
    {
        parent::__construct();
        $this->id           = $clusterId;
        $this->clusterId    = $clusterId;
        $this->gatherData();

        $this->gatherServers();
        $this->scalingModifier = $this->data->scaling_modifier;
        $this->gatherOres();
        $this->gatherIngots();
        $this->gatherComponents();
        $this->gatherFoundationOre();
        $this->gatherFoundationIngot();
    }

    private function gatherData() {
        $this->data = $this->find($this->table, $this->clusterId);

        $serverIds = $this->findPivots('cluster','server', $this->id);
        foreach($serverIds as $serverId) {
            $this->totalServers++;
            $serverTypes = $this->findPivots('server', 'systemtype', $serverId);
            if(!empty($serverTypes)) {
                foreach($serverTypes as $serverType) {
                    if((int)$serverType === 1) {
                        $this->planetIds[] = $serverId;
                        $this->totalPlanets++;
                    } else {
                        $this->asteroidIds[] = $serverId;
                        $this->totalAsteroids++;
                    }
                }
            }
        }
        $this->foundationalOreId    = $this->data->economy_ore;
    }

    private function gatherServers() {
        $this->serverIds = $this->findPivots('cluster','server', $this->clusterId);
        foreach($this->serverIds as $serverId) {
            $this->servers[$serverId] = new Servers($serverId);
        }
    }

    private function gatherOres() {
        $this->oreIds = $this->findPivots('server','ore', $this->serverIds);
        $this->ores = [];
        foreach($this->oreIds as $oreId) {
            $this->ores[$oreId] = new Ores($oreId);
        }
    }

    private function gatherIngots() {
        $this->ingotIds = $this->findPivots('ore','ingot', $this->oreIds);
        $this->ingots = [];
        foreach($this->ingotIds as $ingotId) {
            $this->ingots[$ingotId] = new Ingots($ingotId);
        }
    }

    private function gatherComponents() {
        $components = $this->gatherFromTable('components');
        $this->componentIds = [];
        foreach($components as $component) {
            $this->componentIds[] = $component->id;
        }
        foreach($this->componentIds as $componentId) {
            $this->components[$componentId] = new Components($componentId);
        }
    }

    public function getServers() {
        return $this->servers;
    }

    public function getServerIds() {
        return array_flip($this->servers);
    }

    public function getTotalServers() {
        return $this->totalServers;
    }

    public function getScalingModifier() {
        return $this->scalingModifier;
    }

    public function getFoundationalOreValue() {
        return $this->foundationOreData->base_cost_to_gather*$this->magic->getOreGatherCost();
    }

    public function getStoneModifier() {
        return $this->data->economy_stone_modifier;
    }

    public function getAsteroidScarcityModifier() {
        return $this->data->asteroid_scarcity_modifier;
    }

    public function getPlanetScarcityModifier() {
        return $this->data->planet_scarcity_modifier;
    }

    public function getBaseModifier() {
        return $this->data->base_modifier;
    }

    public function getOres($id = null) {
        if(!empty($id)) {
            return $this->ores[$id];
        }
        return $this->ores;
    }

    public function getIngots($id = null) {
        if(!empty($id)) {
            return $this->ingots[$id];
        }
        return $this->ingots[$id];
    }

    public function getComponents($id = null) {
        if(!empty($id)) {
            return $this->components[$id];
        }
        return $this->components[$id];
    }

    public function getClusterId() {
        return $this->id;
    }


    private function gatherFoundationOre() {
        $this->foundationOreData = $this->find('ores',  $this->foundationalOreId);
    }

    private function gatherFoundationIngot() {
        $this->foundationalIngotId = $this->findPivots('ore','ingot', $this->foundationalOreId)[0];

        $this->foundationIngotData      = $this->find('ingots', $this->foundationalIngotId);
        $this->foundationOrePerIngot    = $this->foundationIngotData->ore_required;
    }

}