<?php namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ActiveTransactions
 * note: holds the most recent transactions from a store
 *
 * @property int                   $tradestation_id
 * @property int                   $server_id
 * @property int                   $world_id
 * @property int                   $transaction_type
 * @property int                   $good_type
 * @property int                   $good_id
 * @property double                $value
 * @property double                $amount
 * @property string                $created_at
 * @property string                $updated_at
 * @package Models
 */
class ActiveTransactions extends Model
{
    protected $table = 'active_transactions';
    protected $fillable = ['tradestation_id','server_id','world_id', 'transaction_type','good_type','good_id','value','amount','created_at'];
}
