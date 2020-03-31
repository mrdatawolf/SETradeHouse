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

        return 1;
    }

    public function getStoreAdjustedValue() {
        return $this->getBaseValue();
    }

    public function getScarcityAdjustment() {
        return 1;
    }

    public function getScarcityAdjustedValue() {
        return 1;
    }
}