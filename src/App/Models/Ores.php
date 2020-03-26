<?php namespace Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Ores
 *
 * @property int                   $id
 * @property string                $title
 * @property                       $base_cost_to_gather
 * @property                       $base_processing_time_per_ore
 * @property                       $base_conversion_efficiency
 * @property                       $keen_crap_fix
 * @property                       $module_efficiency_modifier
 * @package Models
 */
class Ores extends Model
{
    protected $table = 'ores';
    protected $fillable = ['title','base_cost_to_gather','base_processing_time_per_ore','base_conversion_efficiency','keen_crap_fix','module_efficiency_modifier'];
}