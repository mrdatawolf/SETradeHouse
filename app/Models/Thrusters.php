<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Ores
 *
 * @property int    $id
 * @property string $ship_size
 * @property string $size
 * @property string $type
 * @property int    $newtons
 * @property int    $power_draw
 * @property int    $weight
 * @property bool   $functions_in_space
 * @package Models
 */
class Thrusters extends Model
{
    public    $timestamps = true;
    protected $table      = 'thrusters';
    protected $fillable   = [
        'size',
        'ship_size',
        'type',
        'newtons',
        'power_draw',
        'weight',
        'functions_in_space'
    ];

}
