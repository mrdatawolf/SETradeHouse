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

    public function listedValue($clusterId, $typeId, $id) {
        $avgValue = $totalValue = 0;
        $transactionsCount = 0;
        $transactions = $this->activeTransactions;

        foreach($transactions as $transaction) {
            if($transaction->clusters_id == $clusterId && $transaction->goods_type_id == $typeId && $transaction->goods_id == $id) {
                $transactionsCount++;
                $totalValue += $transaction->value;
            }

        }
        if($totalValue > 0) {
            $avgValue = $totalValue/$transactionsCount;
        }

        return $avgValue;
    }

    public function getDesire($clusterId, $typeId, $id) {
        return $this->getTotalBuyOrders($clusterId, $typeId, $id) - $this->getTotalSellOrders($clusterId, $typeId, $id);
    }

    public function getTotalBuyOrders($clusterId, $typeId, $id) {
        return $this->getOrdersTransactionType($clusterId, 1, $typeId, $id);
    }

    public function getTotalSellOrders($clusterId, $typeId, $id) {
        return $this->getOrdersTransactionType($clusterId, 2, $typeId, $id);
    }


    private function getOrdersTransactionType($clusterId, $transactionTypeId, $typeId, $id) {
        $totalAmount = 0;
        $transactions = $this->activeTransactions;
        foreach($transactions as $transaction) {
            if($transaction->clusters_id == $clusterId && $transaction->transaction_type_id ==  $transactionTypeId && $transaction->goods_type_id == $typeId && $transaction->goods_id == $id) {
                $totalAmount += $transaction->amount;
            }
        }

        return $totalAmount;
    }
}