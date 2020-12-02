<?php namespace App\Models;

use App\Http\Traits\ScarcityAdjustment;
use Illuminate\Database\Eloquent\Model;
use \Session;

/**
 * Class Ores
 * @property int                   $id
 * @property string                $title
 * @property                       $base_processing_time_per_ore
 * @property                       $base_conversion_efficiency
 * @property                       $keen_crap_fix
 * @property                       $module_efficiency_modifier
 * @property                       $ore_per_ingot
 * @property                       $se_name
 * @property                       $servers
 * @property                       $worlds
 *
 * @package App
 */
class Ores extends Model
{
    use ScarcityAdjustment;

    public $timestamps = false;
    protected $table = 'ores';
    protected $primaryKey = 'id';
    protected $connection = 'main';


    public function ingots() {
        return $this->belongsToMany('App\Models\Ingots');
    }


    public function worlds() {
        return $this->belongsToMany('App\Models\Worlds');
    }


    public function servers() {
        return $this->belongsToMany('App\Models\Servers');
    }


    public function getTotalInStorage() {

        return Session::get('stockLevels')['Ores'][$this->title];
    }


    public function getOreEfficiency($modules = 0) {
        $modifer = $modules*$this->module_efficiency_modifier;

        return $this->base_conversion_efficiency + $modifer;
    }


    public function getRefineryKiloWattHourUsage($refinerySpeed, $refineryKWH) {
        $speedPerOre = $refinerySpeed/$this->base_processing_time_per_ore;
        $return = 0;
        if(!empty($refineryKWH) && !empty($this->base_processing_time_per_ore)) {
            $return = $refineryKWH / $speedPerOre / 60 / 60;
        }

        return $return;
    }


    /**
     * note: if this is ore 10 (stone) adjust based on the server's preference. If it's the econ ore then we do 1 for 1. Otherwise we do the *2 modifier
     * note: why did I make it *2... hmm
     * @return float|int
     */
    public function getBaseValue() {
        $server = $this->servers->first();
        switch($this->id) {
            case 10 :
                $basisModifier = $server->economy_stone_modifier;
                break;
            case $server->economy_ore_id :
                $basisModifier = 1;
                break;
            default :
                $basisModifier = 2;
        }

        return $this->ore_per_ingot * $basisModifier;
    }


    /**
     * note: testing ignoring the keen fixes and letting the market determine everything.
     *
     * @return float|int
     */
    public function getKeenStoreAdjustedValue() {
        $this->keen_crap_fix = 1;
        return (empty($this->getBaseValue()) || empty($this->keen_crap_fix)) ? 0
            : $this->getBaseValue() * $this->keen_crap_fix;
    }


    /**
     * @param     $economyOre
     * @param     $scalingModifier
     * @param int $total
     *
     * @return float|int
     */
    public function getBaseCostToGatherOre($economyOre, $scalingModifier, $total = 1) {
        $econOrePerIngot = $economyOre->ore_per_ingot;
        $orePerIngot = $this->ore_per_ingot;
        return (($orePerIngot/$econOrePerIngot)*$scalingModifier)*$total;
    }


    /**
     * @param int $modules //<-- specifically effeciency modules
     *
     * @return float|int|mixed
     */
    public function getOreRequiredPerIngot($modules = 0) {
        $orePerIngot                = $this->ore_per_ingot;
        $moduleEfficiencyModifier   = $this->module_efficiency_modifier;
        $modifer                    = $modules*$moduleEfficiencyModifier;

        return $orePerIngot - $modifer;
    }


    /**
     *
     * @return int
     */
    public function getPlanets() {
        return $this->getWorldOfType(1);
    }


    /**
     *
     * @return int
     */
    public function getAsteroids() {
        return $this->getWorldOfType(2);
    }


    /**
     * @param $type
     *
     * @return int
     */
    private function getWorldOfType($type) {
        $serverId = $this->currentUser->server_id;
        $totalWith = 0;
        foreach($this->worlds as $world) {
            if($world->server_id == $serverId && $world->types_id == $type) {
                $totalWith++;
            }
        }

        return $totalWith;
    }
}
