<?php namespace Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Ingots
 *
 * @property int                   $id
 * @property string                $title
 * @property                       $ore_required
 * @property                       $base_ore
 * @property                       $keen_crap_fix
 * @package Models
 */
class Ingots extends Model
{
    protected $table = 'ingots';
    protected $fillable = ['title','keen_crap_fix'];

    public function ores() {
        return $this->belongsToMany('Models\Ores');
    }

    public function getEfficiencyPerSecond($baseMultiplierForBuyVsSell, $baseLaborPerHour) {
        $ore = $this->ores()->first();
        $derivedEfficiency  = $baseMultiplierForBuyVsSell*$ore->base_conversion_efficiency;
        $time               = ($baseLaborPerHour/$ore->base_processing_time_per_ore);

        return $derivedEfficiency*$time;
    }

    public function getBaseValue($modules = 0) {
        $ore = $this->ores()->first();
        $oreRequired = $this->getOreRequiredPerIngot($ore, $modules);

        return $ore->getBaseValue()*$oreRequired;
    }

    public function getStoreAdjustedValue() {
        $ore = $this->ores()->first();

        return $this->getBaseValue($ore->module_efficiency_modifier)*$this->keen_crap_fix;
    }

    public function getScarcityAdjustment($totalServers, $planetsWith, $asteroidsWith) {
        $totalServersWithOre = $planetsWith+$asteroidsWith;

        return ($totalServersWithOre === $totalServers) ? $totalServers*10 : ($planetsWith * 10) + ($asteroidsWith * 5);
    }

    public function getScarcityAdjustedValue($totalServers, $planetsWith, $asteroidsWith) {
        $scarcityAdjustment = $this->getScarcityAdjustment($totalServers, $planetsWith, $asteroidsWith);
        $storeAdjustedValue = $this->getStoreAdjustedValue();

        return $storeAdjustedValue*(2-($scarcityAdjustment/$totalServers));
    }

    public function getOreRequiredPerIngot($ore, $modules = 0) {
        $orePerIngot                = $ore->ore_per_ingot;
        $moduleEfficiencyModifier   = $ore->module_efficiency_modifier;
        $modifer                    = $modules*$moduleEfficiencyModifier;

        return $orePerIngot - $modifer;
    }
}