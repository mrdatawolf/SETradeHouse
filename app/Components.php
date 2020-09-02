<?php namespace App;

use App\Http\Traits\ScarcityAdjustment;
use Illuminate\Database\Eloquent\Model;
use \Session;

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
 * @property                       $servers
 * @property                       $mass
 * @property                       $volume
 * @package Models
 */
class Components extends Model
{
    use ScarcityAdjustment;

    protected $table = 'components';
    protected $fillable = ['title','se_name','cobalt','gold','iron','magnesium','nickel','platinum','silicon','silver','gravel','uranium','mass','volume'];

    /**
     * note: take all the ingots used to make this and their base value to get a price for the component.
     * @return float|int
     */
    public function getBaseValue() {
        $value  = 0;
        $ingots = Ingots::all();
        foreach ($ingots as $ingot) {
            $title  = $ingot->title;
            $needed = $this->$title;
            if($needed > 0) {
                $value += $ingot->getBaseValue() * $needed;
            }
        }

        return $value;
    }


    public function getTotalInStorage() {

        return Session::get('stockLevels')['Components'][$this->title];
    }


    /**
     * note: get the value of the component based on the store price.
     * @return float|int
     */
    public function getKeenStoreAdjustedValue() {
        $value  = 0;
        $ingots = Ingots::all();
        foreach ($ingots as $ingot) {
            $title  = $ingot->title;
            $needed = $this->$title;
            if($needed > 0) {
                $value += $ingot->getKeenStoreAdjustedValue() * $needed;
            }
        }

        return $value;
    }
}
