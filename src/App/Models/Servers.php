<?php namespace Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Ores
 *
 * @property int                   $id
 * @property string                $title
 * @property                       $system_stock_weight
 * @property int                   $cluster_id
 * @property                       $activeTransactions
 * @property                       $tradezones
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

    public function tradezones() {
        return $this->hasMany('Models\TradeZones');
    }

    public function types() {
        $this->hasMany('Models\ServerTypes');
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
            if($transaction->goods_type_id == $typeId && $transaction->goods_id == $id) {
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
            if($transaction->transaction_type_id ==  $transactionTypeId && $transaction->goods_type_id == $typeId && $transaction->goods_id == $id) {
                $totalAmount += $transaction->amount;
            }
        }

        return $totalAmount;
    }
}