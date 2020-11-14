<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Transactions
 * note: holds the most recent transactions from a store
 *
 * @property int                   $trade_zone_id
 * @property int                   $owner
 * @property int                   $server_id
 * @property int                   $world_id
 * @property int                   $transaction_type_id
 * @property int                   $good_type_id
 * @property int                   $good_id
 * @property double                $value
 * @property double                $amount
 * @property string                $created_at
 * @property string                $updated_at
 * @package Models
 */
class Transactions extends Model
{
    protected $connection   ='transactions';
    protected $table = 'transactions';
    public $timestamps = true;
    protected $fillable = ['trade_zone_id','owner', 'server_id','world_id', 'transaction_type_id','good_type_id','good_id','value','amount'];
}
