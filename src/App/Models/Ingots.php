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
 * @property                       $ores
 * @property                       $servers
 * @property                       $clusters
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

    public function clusters() {
        return $this->belongsToMany('Models\Clusters');
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
        return (empty($this->getBaseValue()) || empty($this->keen_crap_fix)) ? 0
            : $this->getBaseValue() * $this->keen_crap_fix;
    }


    /**
     * @param $totalServers
     * @param $clusterId
     * note: Ingots are made from ores. So the amount of ores will effect the scarcity here but not as much as an ingot order.
     * todo: get total active ingot desire.
     * todo: get total active ore desire. Then divide by magic base_weight_for_each_system and the amount ore ore per to make an ingot then apply this to the scarcity value being returned.  Later we can dial this in.
     * @return float|int
     */
    public function getScarcityAdjustment($totalServers,$clusterId) {
        $planetsWith = $this->getPlanetsWith($clusterId);
        $asteroidsWith = $this->getAsteroidsWith($clusterId);
        $totalServersWithIngot = $planetsWith+$asteroidsWith;

        return ($totalServersWithIngot === $totalServers) ? $totalServers*10 : ($planetsWith * 10) + ($asteroidsWith * 5);
    }

    public function getScarcityAdjustedValue($totalServers, $clusterId) {
        $storeAdjustedValue = $this->getStoreAdjustedValue();
        $scarcityAdjustment = $this->getScarcityAdjustment($totalServers, $clusterId);

        return $storeAdjustedValue*(2-($scarcityAdjustment/($totalServers*10)));
    }

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