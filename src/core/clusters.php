<?php namespace Core;

use DB\dbClass;

class Clusters extends dbClass
{
    public $id;
    public $totalServers = 0;
    public $totalPlanets = 0;
    public $totalAsteroids = 0;

    protected $data;
    protected $servers;
    protected $scalingModifier;
    protected $serverIds;
    protected $magicNumbersClass;
    protected $oreIds;
    protected $ores;
    protected $ingotIds;
    protected $ingots;
    protected $componentIds;
    protected $components;

    private $table = 'clusters';

    public function __construct()
    {
        parent::__construct();
        $this->id   = $this->clusterId;
        $this->gatherData();

        $this->gatherServers();
        $this->scalingModifier = $this->clusterData->scaling_modifier;
        $this->magicNumbersClass = new MagicNumbers();
        $this->gatherOres();
        $this->gatherIngots();
        $this->gatherComponents();
    }

    private function gatherData() {
        $this->data = $this->clusterData;
    }

    private function gatherServers() {
        $this->serverIds = $this->findPivots('cluster','server', $this->clusterId);
        foreach($this->serverIds as $serverId) {
            $this->totalServers++;
            $serverTypes = $this->findPivots('server', 'systemtype', $serverId);
            if(!empty($serverTypes)) {
                foreach($serverTypes as $serverType) {
                    if($serverType === 1) {
                        $this->totalPlanets++;
                    } else {
                        $this->totalAsteroids++;
                    }
                }

            }
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

    public function getTotalServers() {
        return $this->totalServers;
    }

    public function getScalingModifier() {
        return $this->scalingModifier;
    }

    public function getFoundationalOreValue() {
        return $this->foundationOreData->base_cost_to_gather*$this->magicNumbersClass->getOreGatherCost();
    }

    public function getStoneModifier() {
        return $this->clusterData->economy_stone_modifier;
    }

    public function getAsteroidScarcityModifier() {
        return $this->clusterData->asteroid_scarcity_modifier;
    }

    public function getPlanetScarcityModifier() {
        return $this->clusterData->planet_scarcity_modifier;
    }

    public function getBaseModifier() {
        return $this->clusterData->base_modifier;
    }

    public function getOres() {
        return $this->ores;
    }

    public function getIngots() {
        return $this->ingots;
    }

    public function getComponents() {
        return $this->components;
    }
}