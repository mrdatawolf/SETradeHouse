<?php namespace Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TradeZones
 *
 * @property int                   $id
 * @property string                $title
 * @property                       $owner_id
 * @property                       $station_id
 * @property                       $local_weight
 * @package Models
 */
class TradeZones extends Model
{
    protected $table = 'trade_zones';
    protected $fillable = ['title','owner_id','station_id','local_weight'];
}