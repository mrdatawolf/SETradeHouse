<?php namespace Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Clusters
 *
 * @property int                   $id
 * @property string                $title
 * @property                       $economy_ore
 * @property                       $economy_stone_modifier
 * @property                       $scaling_modifier
 * @property                       $economy_ore_value
 * @property                       $asteroid_scarcity_modifier
 * @property                       $planet_scarcity_modifier
 * @property                       $base_modifier
 * @package Models
 */
class Clusters extends Model
{
    protected $table = 'clusters';
    protected $fillable = ['title','economy_ore', 'economy_stone_modifier','scaling_modifier','economy_ore_value','asteroid_scarcity_modifier', 'planet_scarcity_modifier', 'base_modifier'];

    public function clusters() {
        return $this->belongsToMany('Models\Clusters');
    }
}