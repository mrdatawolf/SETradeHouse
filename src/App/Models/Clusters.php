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
 * @property                       $economyOre
 * @property                       $ores
 * @property                       $ingots
 * @property                       $servers
 * @package Models
 */
class Clusters extends Model
{
    protected $table = 'clusters';
    protected $fillable = ['title','economy_ore', 'economy_stone_modifier','scaling_modifier','economy_ore_value','asteroid_scarcity_modifier', 'planet_scarcity_modifier', 'base_modifier'];

    public function economyOre() {
        return$this->hasOne('Models\Ores', 'id', 'economy_ore_id');
    }

    public function ores() {
        return $this->belongsToMany('Models\Ores');
    }

    public function ingots() {
        return $this->belongsToMany('Models\Ingots');
    }

    public function servers() {
        return $this->hasMany('Models\Servers');
    }
}