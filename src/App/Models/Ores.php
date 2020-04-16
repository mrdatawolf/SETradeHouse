<?php namespace Models;

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
 * @package Models
 */
class Ores extends Model
{
    protected $table = 'ores';
    protected $fillable = ['title','base_cost_to_gather','base_processing_time_per_ore','base_conversion_efficiency','keen_crap_fix','module_efficiency_modifier'];


    public function ingots() {
        return $this->belongsToMany('Models\Ingots');
    }

    public function servers() {
        return $this->belongsToMany('Models\Servers');
    }

    public function clusters() {
        return $this->belongsToMany('Models\Clusters');
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

    public function getScarcityAdjustedValue($totalServers, $planetsWith, $asteroidsWith) {
        $storeAdjustedValue = $this->getStoreAdjustedValue();
        $scarcityAdjustment = $this->getScarcityAdjustment($totalServers, $planetsWith, $asteroidsWith);

        return $storeAdjustedValue*(2-($scarcityAdjustment/($totalServers*10)));
    }

    public function getScarcityAdjustment($totalServers, $planetsWith, $asteroidsWith) {

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
}