<?php namespace Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Clusters
 *
 * @property int                   $id
 * @property string                $title
 * @property                       $economy_ore
 * @property                       $economy_stone_modifier
 * @property                       $scaling_modifier
 * @property                       $economy_ore_value
 * @property                       $asteroid_scarcity_modifier
 * @property                       $planet_scarcity_modifier
 * @property                       $base_modifier
 * @property                       $economyOre
 * @property                       $ores
 * @property                       $ingots
 * @property                       $servers
 * @package Models
 */
class Clusters extends Model
{
    protected $table = 'clusters';
    protected $fillable = ['title','economy_ore', 'economy_stone_modifier','scaling_modifier','economy_ore_value','asteroid_scarcity_modifier', 'planet_scarcity_modifier', 'base_modifier'];

    public function economyOre() {
        return$this->hasOne('Models\Ores', 'id', 'economy_ore_id');
    }

    public function ores() {
        return $this->belongsToMany('Models\Ores');
    }

    public function ingots() {
        return $this->belongsToMany('Models\Ingots');
    }

    public function servers() {
        return $this->hasMany('Models\Servers');
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