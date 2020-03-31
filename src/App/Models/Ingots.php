<?php namespace Models;

use Illuminate\Database\Eloquent\Model;
use Controllers\Ores as Ore;

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
    protected $fillable = ['title','ore_required','base_ore','keen_crap_fix'];

    public function getEfficiencyPerSecond($baseMultiplierForBuyVsSell, $baseLaborPerHour) {
        $ore = Ores::find($this->base_ore);
        $derivedEfficiency  = $baseMultiplierForBuyVsSell*$ore->base_conversion_efficiency;
        $time               = ($baseLaborPerHour/$ore->base_processing_time_per_ore);

        return $derivedEfficiency*$time;
    }

    public function getBaseValue($modules = 0) {
        $ores = new Ores();
        $ore = Ores::find($this->base_ore);
        $oreRequired = $this->getOreRequiredPerIngot($ore->module_efficiency_modifier, $modules);

        return $ores->getBaseValue($oreRequired)*$ores->getStoreAdjustedValue($oreRequired);
    }

    public function getStoreAdjustedMinimum() {
        $ore = Ores::find($this->base_ore);
        return $this->getBaseValue($ore->module_efficiency_modifier)*$this->keen_crap_fix;
    }

    public function getOreRequiredPerIngot($moduleEfficiencyModifier, $modules = 0) {
        $modifer = $modules*$moduleEfficiencyModifier;

        return $this->ore_required - $modifer;
    }
}