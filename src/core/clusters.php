<?php namespace Core;

use DB\dbClass;
use Core\MagicNumbers;

class Clusters extends dbClass
{
    public $id;
    public $clusterId;
    public $totalServers = 0;
    public $totalPlanets = 0;
    public $totalAsteroids = 0;
    public $data;

    protected $scalingModifier;
    protected $serverIds    = [];
    protected $oreIds       = [];
    protected $ingotIds     = [];
    protected $planetIds    = [];
    protected $asteroidIds  = [];

    private $table = 'clusters';

    public function __construct($clusterId)
    {
        parent::__construct();
        $this->id           = $clusterId;
        $this->clusterId    = $clusterId;
        $this->gatherData();
        $this->gatherSystemTypes();

        $this->scalingModifier = $this->data->scaling_modifier;
    }

    private function gatherData() {
        $this->data = $this->find($this->table, $this->clusterId);

        $this->serverIds    = $this->findPivots('cluster','server', $this->id);
        $this->totalServers = count($this->serverIds);
    }

    private function gatherSystemTypes() {
        foreach($this->serverIds as $serverId) {
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
            foreach ($this->findPivots('server', 'ore', $serverId) as $oreId) {
                if ( ! in_array($oreId, $this->oreIds)) {
                    $this->oreIds[] = $oreId;
                }
                foreach ($this->findPivots('ore', 'ingot', $oreId) as $ingotId) {
                    if ( ! in_array($ingotId, $ingotId)) {
                        $this->ingotIds[] = $ingotId;
                    }
                }
            }



        }
    }


    public function getServerIds() {
        return $this->serverIds;
    }

    public function getOreIds() {
        return $this->oreIds;
    }

    public function getIngotIds() {
        return $this->ingotIds;
    }

    public function getTotalServers() {
        return $this->totalServers;
    }

    public function getScalingModifier() {
        return $this->scalingModifier;
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

    public function getClusterId() {
        return $this->id;
    }

}