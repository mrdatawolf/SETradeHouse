<?php namespace Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class WorldTypes
 *
 * @property int                   $id
 * @property string                $title
 * @package Models
 */
class WorldTypes extends Model
{
    protected $table = 'server_types';
    protected $fillable = ['title'];
}
