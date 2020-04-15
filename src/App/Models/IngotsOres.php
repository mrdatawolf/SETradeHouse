<?php namespace Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Ores
 *
 * @property int                    $ingots_id
 * @property int                    $ores_id
 * @property double                 $ore_per_ingot
 * @package Models
 */
class IngotsOres extends Model
{
    protected $table = 'ingots_ores';
    protected $fillable = [];

}