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
    protected $fillable = ['title','se_name','cobalt','gold','iron','magnesium','nickel','platinum','silicon','silver','gravel','uranium','mass','volume'];


    /**
     * note: take all the ingots used to make this and their base value to get a price for the component.
     * @return float|int
     */
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


    /**
     * note: get the value of the component based on the store price.
     * @return float|int
     */
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
     * note: get the value of the component based on the scarcity prices.
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