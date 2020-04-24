<?php namespace Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Components
 *
 * @property int                   $id
 * @property string                $title
 * @property                       $cobalt
 * @property                       $gold
 * @property                       $iron
 * @property                       $magnesium
 * @property                       $nickel
 * @property                       $platinum
 * @property                       $silicon
 * @property                       $silver
 * @property                       $gravel
 * @property                       $uranium
 * @property                       $mass
 * @property                       $volume
 * @package Models
 */
class Components extends Model
{
    protected $table = 'components';
    protected $fillable = ['title','cobalt','gold','iron','magnesium','nickel','platinum','silicon','silver','gravel','uranium','mass','volume'];

    public function getBaseValue() {
        $value = 0;
        $ingots = Ingots::all();
        foreach ($ingots as $ingot) {
            $title = $ingot->title;
            $needed       = $this->$title;
            if($needed > 0) {
                $value += $ingot->getBaseValue() * $needed;
            }
        }

        return $value;
    }

    public function getStoreAdjustedValue() {
        $value = 0;
        $ingots = Ingots::all();
        foreach ($ingots as $ingot) {
            $title = $ingot->title;
            $needed       = $this->$title;
            if($needed > 0) {
                $value += $ingot->getStoreAdjustedValue() * $needed;
            }
        }

        return $value;
    }


    /**
     * @param $totalServers
     * @param $clusterId
     *
     * @return float|int
     */
    public function getScarcityAdjustedValue($totalServers, $clusterId) {
        $value = 0;
        $ingots = Ingots::all();
        foreach ($ingots as $ingot) {
            $title = $ingot->title;
            $needed       = $this->$title;
            if($needed > 0) {
                $value += $ingot->getScarcityAdjustedValue($totalServers, $clusterId) * $needed;
            }
        }

        return $value;
    }
}