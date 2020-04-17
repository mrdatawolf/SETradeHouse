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
 * @property                       $servers
 * @package Models
 */
class TradeZones extends Model
{
    protected $table = 'trade_zones';
    protected $fillable = ['title','owner_id','station_id','local_weight'];

    public function servers() {
        return $this->belongsTo('Models\Servers');
    }

    public function activeTransactions() {
        return $this->hasMany('Models\ActiveTransactions');
    }

    public function getTotalBuyOrders($typeId, $id) {
        return $this->getOrdersTransactionType(1, $typeId, $id);
    }

    public function getTotalSellOrders($typeId, $id) {
        return $this->getOrdersTransactionType(2, $typeId, $id);
    }

    private function getOrdersTransactionType($transactionId, $typeId, $id) {
        $totalAmount = 0;
        $transactions = $this->activeTransactions()
                             ->where('transaction_type', $transactionId)
                             ->where('good_type', $typeId)
                             ->where('good_id', $id)
                             ->get();
        foreach($transactions as $transaction) {
            $totalAmount += $transaction->amount;
        }

        return $totalAmount;
    }
}