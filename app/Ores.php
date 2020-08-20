<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Ores
 *
 * @property int                   $id
 * @property string                $title
 * @property                       $base_processing_time_per_ore
 * @property                       $base_conversion_efficiency
 * @property                       $keen_crap_fix
 * @property                       $module_efficiency_modifier
 * @property                       $ore_per_ingot
 * @property                       $ingots
 * @property                       $servers
 * @property                       $clusters
 * @package App
 */
class Ores extends Model
{
    public $timestamps = false;
    protected $table = 'ores';
    protected $primaryKey = 'id';
    protected $connection = 'sqlite';

    public function ingots() {
        return $this->belongsToMany('App\Ingots');
    }

    public function servers() {
        return $this->belongsToMany('App\Servers');
    }

    public function clusters() {
        return $this->belongsToMany('App\Clusters');
    }

    public function getOreEfficiency($modules = 0) {
        $modifer = $modules*$this->module_efficiency_modifier;

        return $this->base_conversion_efficiency + $modifer;
    }

    public function getRefineryKiloWattHour($refinerySpeed, $refineryKWH) {
        $speedPerOre = $refinerySpeed/$this->base_processing_time_per_ore;
        $return = 0;
        if(!empty($refineryKWH) && !empty($this->base_processing_time_per_ore)) {
            $return = $refineryKWH / $speedPerOre / 60 / 60;
        }

        return $return;
    }

    public function getBaseValue() {
        return ($this->id == 10) ? 0 : $this->ore_per_ingot * 2;
    }

    public function getStoreAdjustedValue() {
        return (empty($this->getBaseValue()) || empty($this->keen_crap_fix)) ? 0
            : $this->getBaseValue() * $this->keen_crap_fix;
    }


    /**
     * @param $totalServers
     * @param $clusterId
     *
     * @return float|int
     */
    public function getScarcityAdjustedValue($totalServers, $clusterId) {
        $storeAdjustedValue = $this->getStoreAdjustedValue();
        $scarcityAdjustment = $this->getScarcityAdjustment($totalServers, $clusterId);

        return $storeAdjustedValue*(2-($scarcityAdjustment/($totalServers*10)));
    }


    /**
     * @param $totalServers
     * @param $clusterId
     * note: ores are the basic building blocks so they don't look at how many ingots etc are out there f the raw ore.
     *
     * @return float|int
     */
    public function getScarcityAdjustment($totalServers, $clusterId) {
        $planetsWith = $this->getPlanetsWith($clusterId);
        $asteroidsWith = $this->getAsteroidsWith($clusterId);
        $totalServersWithOre = $planetsWith+$asteroidsWith;

        return ($totalServersWithOre === $totalServers) ? $totalServers*10 : ($planetsWith * 10) + ($asteroidsWith * 5);
    }

    public function getBaseCostToGatherOre($economyOre, $scalingModifier, $total = 1) {
        $econOrePerIngot = $economyOre->ore_per_ingot;
        $orePerIngot = $this->ore_per_ingot;
        return (($orePerIngot/$econOrePerIngot)*$scalingModifier)*$total;
    }

    public function getOreRequiredPerIngot($modules = 0) {
        $orePerIngot                = $this->ore_per_ingot;
        $moduleEfficiencyModifier   = $this->module_efficiency_modifier;
        $modifer                    = $modules*$moduleEfficiencyModifier;

        return $orePerIngot - $modifer;
    }

    public function getPlanetsWith($clusterId) {
        return $this->getServerOfTypeWith(1, $clusterId);
    }

    public function getAsteroidsWith($clusterId) {
        return $this->getServerOfTypeWith(2, $clusterId);
    }

    private function getServerOfTypeWith($type, $clusterId) {
        $totalWith = 0;
        foreach($this->servers as $server) {
            if($server->clusters_id == $clusterId) {
                if ($server->types_id == $type) {
                    $totalWith++;
                }
            }
        }

        return $totalWith;
    }
}
