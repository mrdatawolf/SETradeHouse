<?php namespace App;

use App\Http\Traits\ScarcityAdjustment;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Tools
 *
 * @property int                   $id
 * @property string                $title
 * @property string                $se_name
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
 * @property                       $naquadah
 * @property                       $trinium
 * @property                       $neutronium
 * @property                       $mass
 * @property                       $volume
 * @package Models
 */
class Tools extends Model
{
    use ScarcityAdjustment;

    public    $timestamps = false;
    protected $table      = 'tools';
    protected $fillable   = [
        'title',
        'se_name',
        'cobalt',
        'gold',
        'iron',
        'magnesium',
        'nickel',
        'platinum',
        'silicon',
        'silver',
        'gravel',
        'uranium',
        'naquadah',
        'trinium',
        'neutronium',
        'mass',
        'volume'
    ];


    /**
     * note: take all the ingots used to make this and their base value to get a price for the component.
     *
     * @return float|int
     */
    public function getBaseValue()
    {
        $value  = 0;
        $ingots = Ingots::all();
        foreach ($ingots as $ingot) {
            $title  = $ingot->title;
            $needed = $this->$title;
            if ($needed > 0) {
                $value += $ingot->getBaseValue() * $needed;
            }
        }

        return $value;
    }


    /**
     * note: get the value of the component based on the store price.
     *
     * @return float|int
     */
    public function getKeenStoreAdjustedValue()
    {
        $value  = 0;
        $ingots = Ingots::all();
        foreach ($ingots as $ingot) {
            $title  = $ingot->title;
            $needed = $this->$title;
            if ($needed > 0) {
                $value += $ingot->getKeenStoreAdjustedValue() * $needed;
            }
        }

        return $value;
    }
}
