<?php namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Ores
 *
 * @property int                   $trade_zone_id
 * @property string                $owner
 * @property int                   $server_id
 * @property int                   $world_id
 * @property int                   $transaction_type_id
 * @property int                   $good_type_id
 * @property int                   $good_id
 * @property double                $value
 * @property double                $amount
 * @package Models
 */
class InActiveTransactions extends Model
{
    protected $table = 'inactive_transactions';
    protected $fillable = ['trade_zone_id', 'owner', 'server_id','world_id', 'transaction_type_id','good_type_id','good_id','value','amount'];
}
