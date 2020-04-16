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

    public function servers() {
        return $this->belongsToMany('Models\Servers');
    }

    public function getEfficiencyPerSecond($moduleBaseEffeciency, $baseRefinerySpeed) {
        $ore = $this->ores()->first();

        return ($moduleBaseEffeciency*$ore->base_conversion_efficiency)*($baseRefinerySpeed/$ore->base_processing_time_per_ore);
    }

    public function getBaseValue($modules = 0) {
        $ore = $this->ores()->first();
        $oreRequired = $ore->getOreRequiredPerIngot($modules);

        return $oreRequired*$ore->getStoreAdjustedValue();
    }

    public function getStoreAdjustedValue() {
        return $this->getBaseValue()*$this->keen_crap_fix;
    }

    public function getScarcityAdjustment($totalServers, $planetsWith, $asteroidsWith) {
        $totalServersWithIngot = $planetsWith+$asteroidsWith;

        return ($totalServersWithIngot === $totalServers) ? $totalServers*10 : ($planetsWith * 10) + ($asteroidsWith * 5);
    }

    public function getScarcityAdjustedValue($totalServers, $planetsWith, $asteroidsWith) {
        return $this->getStoreAdjustedValue();
    }

    public function getOreRequiredPerIngot($modules = 0) {
        $ore = $this->ores()->first();

        return $ore->getOreRequiredPerIngot($modules);
    }
}