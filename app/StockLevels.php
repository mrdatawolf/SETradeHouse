<?php namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Ores
 *
 * @property int                   $id
 * @property string                $server_id
 * @property                       $user_id
 * @property int                   $amount
 * @property                       $good_type
 * @property                       $good_id
 * @property                       $created_at
 * @property                       $updated_at
 * @package Models
 */
class StockLevels extends Model
{
    protected $table = 'hobo.everyonesitems';
    protected $fillable = ['Owner','Item', 'Qty','Timestamp'];


}
