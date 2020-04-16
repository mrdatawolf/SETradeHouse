<?php namespace Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Ores
 *
 * @property int                   $id
 * @property string                $title
 * @property                       $system_stock_weight
 * @property int                   $cluster_id
 * @package Models
 */
class Servers extends Model
{
    protected $table = 'servers';
    protected $fillable = ['title','system_stock_weight', 'cluster_id'];

    public function ores() {
        $this->belongsToMany('Models\Ores');
    }

    public function ingots() {
        return $this->belongsToMany('Models\Ingots');
    }

    public function clusters() {
        return $this->belongsTo('Models\Clusters');
    }

    public function types() {
        $this->hasMany('Models\ServerTypes');
    }
}