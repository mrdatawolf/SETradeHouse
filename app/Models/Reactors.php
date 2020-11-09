<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Ores
 *
 * @property int    $id
 * @property string $ship_size
 * @property string $size
 * @property string $type
 * @property int    $watts
 * @package Models
 */
class Reactors extends Model
{
    public    $timestamps = true;
    protected $table      = 'reactors';
    protected $fillable   = [
        'size',
        'ship_size',
        'title',
        'watts',
    ];

}
