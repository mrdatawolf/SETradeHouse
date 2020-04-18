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
 * @property                       $activeTransactions
 * @package Models
 */
class TradeZones extends Model
{
    protected $table = 'trade_zones';
    protected $fillable = ['title','owner_id','servers_id','local_weight'];

    public function servers() {
        return $this->belongsTo('Models\Servers');
    }

    public function activeTransactions() {
        return $this->hasMany('Models\ActiveTransactions');
    }

    public function listedValue($typeId, $id) {
        $avgValue = $totalValue = 0;
        $transactionsCount = 0;
        $transactions = $this->activeTransactions;

        foreach($transactions as $transaction) {
            $transactionsCount++;
            if($transaction->good_type == $typeId && $transaction->good_type == $id) {
                $totalValue += $transaction->value;
            }
        }
        if($totalValue > 0) {
            $avgValue = $totalValue/$transactionsCount;
        }

        return $avgValue;
    }
    public function getDesire($typeId, $id) {
        return $this->getTotalBuyOrders($typeId, $id) - $this->getTotalSellOrders($typeId, $id);
    }

    public function getTotalBuyOrders($typeId, $id) {
        return $this->getOrdersTransactionType(1, $typeId, $id);
    }

    public function getTotalSellOrders($typeId, $id) {
        return $this->getOrdersTransactionType(2, $typeId, $id);
    }

    private function getOrdersTransactionType($transactionTypeId, $typeId, $id) {
        $totalAmount = 0;
        $transactions = $this->activeTransactions;
        foreach($transactions as $transaction) {
            if($transaction->transaction_type ==  $transactionTypeId && $transaction->good_type == $typeId && $transaction->good_type == $id) {
                $totalAmount += $transaction->amount;
            }
        }

        return $totalAmount;
    }
}