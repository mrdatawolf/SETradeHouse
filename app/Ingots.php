<?php namespace App;

use App\Http\Traits\ScarcityAdjustment;
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
    use ScarcityAdjustment;

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
        $this->keen_crap_fix = 1;
        return (empty($this->getBaseValue()) || empty($this->keen_crap_fix)) ? 0
            : $this->getBaseValue() * $this->keen_crap_fix;
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


    public function getPlanets() {
        return $this->getServerOfType(1);
    }

    public function getAsteroids() {
        return $this->getServerOfType(2);
    }


    /**
     * type is held in the server_types table
     * @param $type
     *
     * @return int
     */
    private function getServerOfType($type) {
        $serverId = $this->currentUser->server_id;
        $totalWith = 0;
        foreach($this->worlds as $world) {
            if($world->server_id == $serverId) {
                if ($world->types_id == $type) {
                    $totalWith++;
                }
            }
        }

        return $totalWith;
    }
}
