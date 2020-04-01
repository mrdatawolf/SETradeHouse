<?php namespace Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Ores
 *
 * @property int                   $cluster_id
 * @property string                $server_id
 * @property                       $station_id
 * @property                       $stock_type
 * @property                       $current_amount
 * @property                       $desired_amount
 * @package Models
 */
class Stocks extends Model
{
    protected $table = 'stocks';
    protected $fillable = ['cluster_id','server_id', 'station_id','stock_type','current_amount','desired_amount'];
}