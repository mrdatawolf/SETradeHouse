<?php namespace Core;

use DB\dbClass;

class Clusters extends dbClass
{
    protected $id;
    protected $data;
    protected $servers;
    protected $totalServers;
    protected $scalingModifier;
    protected $serverIds;
    protected $magicNumbersClass;
    protected $oreIds;
    protected $ores;

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
    }

    private function gatherData() {
        $this->data = $this->clusterData;
    }

    public function gatherServers() {
        $this->serverIds = $this->findPivots('cluster','server', $this->clusterId);
        $this->totalServers = count($this->serverIds);
        foreach($this->serverIds as $serverId) {
            $this->servers[$serverId] = new Servers($serverId);
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

    public function gatherOres() {
        $this->oreIds = $this->findPivots('server','ore', $this->serverIds);
        $this->ores = [];
        foreach($this->oreIds as $oreId) {
            $ore = new Ores($oreId);
            $this->ores[$oreId] = $ore;
        }
    }

    public function getOres() {
        return $this->ores;
    }
}