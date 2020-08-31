<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \Session;

/**
 * Class Ingots
 * @property int                   $id
 * @property string                $title
 * @property                       $ore_required
 * @property                       $base_ore
 * @property                       $keen_crap_fix
 * @property                       $ores
 * @property                       $servers
 * @property                       $worlds
 * @package App
 */
class Ingots extends Model
{
    protected $table = 'ingots';
    protected $fillable = ['title','keen_crap_fix'];


    public function ores() {
        return $this->belongsToMany('App\Ores');
    }


    public function worlds() {
        return $this->belongsToMany('App\Worlds');
    }


    public function servers() {
        return $this->belongsToMany('App\Servers');
    }


    public function getTotalInStorage() {

        return Session::get('stockLevels')['Ingots'][$this->title];
    }


    public function getEfficiencyPerSecond($moduleBaseEffeciency, $baseRefinerySpeed) {
        $ore = $this->ores()->first();

        return ($moduleBaseEffeciency*$ore->base_conversion_efficiency)*($baseRefinerySpeed/$ore->base_processing_time_per_ore);
    }


    public function getBaseValue($modules = 0) {
        $ore = $this->ores()->first();
        $oreRequired = $ore->getOreRequiredPerIngot($modules);

        return $oreRequired*$ore->getKeenStoreAdjustedValue();
    }


    /**
     * note: testing ignoring the keen fixes and lettign the market determine everything.
     * @return float|int
     */
    public function getKeenStoreAdjustedValue() {
        //$this->keen_crap_fix = 1;
        return (empty($this->getBaseValue()) || empty($this->keen_crap_fix)) ? 0
            : $this->getBaseValue() * $this->keen_crap_fix;
    }


    /**
     * @param $totalServers
     * @param $clusterId
     * @return float|int
     */
    public function getScarcityAdjustment($totalServers,$clusterId) {
        $planetsWith = $this->getPlanetsWith($clusterId);
        $asteroidsWith = $this->getAsteroidsWith($clusterId);
        $totalServersWithIngot = $planetsWith+$asteroidsWith;

        return ($totalServersWithIngot === $totalServers) ? $totalServers*10 : ($planetsWith * 10) + ($asteroidsWith * 5);
    }


    /**
     * @param $totalServers
     * @param $clusterId
     * note: testing ignoring the keen fixes and lettign the market determine everything.
     * note: Ingots are made from ores. So the base ore value will effect the value here but not as much as the ingot orders.
     *
     * @return float|int
     */
    public function getScarcityAdjustedValue($totalServers,$clusterId)  {
        //$this->keen_crap_fix = 1;
        $ingotWeight = 4;
        $ore = $this->ores()->first();

        $value = $this->getBaseScarcityAdjustedValue($totalServers,$clusterId);
        $oreValueAdjustment = $ore->getScarcityAdjustedValue($totalServers, $clusterId)*$ore->getOreRequiredPerIngot(0)*$this->keen_crap_fix;

        return (($value*$ingotWeight)+$oreValueAdjustment)/($ingotWeight+1);
    }

    public function getBaseScarcityAdjustedValue($totalServers, $clusterId) {
        $storeAdjustedValue = $this->getKeenStoreAdjustedValue();
        $scarcityAdjustment = $this->getScarcityAdjustment($totalServers, $clusterId);

        return $storeAdjustedValue*(2-($scarcityAdjustment/($totalServers*10)));
    }


    /**
     * note: this gets the amount of ore it to makes one of these ingots. As modules effect the amount of ore needed to make an ingot we allow for the adjustment here.
     * @param int $modules
     *
     * @return mixed
     */
    public function getOreRequiredPerIngot($modules = 0) {
        $ore = $this->ores()->first();

        return $ore->getOreRequiredPerIngot($modules);
    }


    public function getPlanetsWith($clusterId) {
        return $this->getServerOfTypeWith(1, $clusterId);
    }

    public function getAsteroidsWith($clusterId) {
        return $this->getServerOfTypeWith(2, $clusterId);
    }


    /**
     * type is held in the server_types table
     * @param $type
     * @param $clusterId
     *
     * @return int
     */
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
