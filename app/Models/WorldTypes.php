<?php namespace App\Models;

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
    protected $table = 'world_types';
    protected $fillable = ['title'];

    public function worlds() {
        return $this->hasMany('App\Models\Worlds');
    }
}
