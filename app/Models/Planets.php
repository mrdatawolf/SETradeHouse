<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Ores
 *
 * @property int    $id
 * @property int    $server_id
 * @property int    $world_id
 * @property string $title
 * @property int    $surface_gravity
 * @property int    $atmosphere_height
 * @property int    $breathable_atmosphere_height
 * @package Models
 */
class Planets extends Model
{
    public    $timestamps = true;
    protected $table      = 'planets';
    protected $fillable   = [
        'title',
        'server_id',
        'world_id',
        'surface_gravity',
        'atmosphere_height',
        'breathable_atmosphere_height'
    ];

}
