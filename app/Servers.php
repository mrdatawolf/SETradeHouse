<?php namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Servers
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
 * @property                       $activeTransactions
 * @package Models
 */
class Servers extends Model
{
    protected $table = 'servers';
    protected $fillable = ['title','economy_ore', 'economy_stone_modifier','scaling_modifier','economy_ore_value','asteroid_scarcity_modifier', 'planet_scarcity_modifier', 'base_modifier'];


    /**
     * note: the economyOre is the basic foundation of the economy. It can be any ore (including say a "credit" ore) it just gives us somethign to pin the movements against.
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function economyOre() {
        return$this->hasOne('Models\Ores', 'id', 'economy_ore_id');
    }


    /**
     * note: this is all the ores in the cluster
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function ores() {
        return $this->belongsToMany('Models\Ores');
    }


    /**
     * note: this is all the ingots in the cluster.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function ingots() {
        return $this->belongsToMany('Models\Ingots');
    }


    /**
     * note: this is all the servers in the cluster.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function servers() {
        return $this->hasMany('Models\Servers');
    }


    /**
     * note: this is all the current transactions in the cluster.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function activeTransactions() {
        return $this->hasMany('Models\ActiveTransactions');
    }


    /**
     * note: this takes the active transactions for a specific thing (type of thing id and its id) in this cluster and looks at how many units are in trade and each ones value based on its amount traded to get an average price to list.
     * @param $typeId
     * @param $id
     *
     * @return float|int
     */
    public function listedValue($typeId, $id) {
        $totalValue = 0;
        $totalBeingTraded =  0;
        $transactions = $this->activeTransactions;

        foreach($transactions as $transaction) {
            if($transaction->goods_type_id == $typeId && $transaction->goods_id == $id) {
                $totalBeingTraded += $transaction->amount;
                $totalValue += $transaction->value*$transaction->amount;
            }
        }

        return ($totalValue > 0) ?  $totalValue/$totalBeingTraded : 0;
    }


    /**
     * note: the desire of the cluster for a specific thing (type of thing id and its id) in the cluster. Where desire is expressed as the total trades buying a thing minus those selling the thing.
     * @param $typeId
     * @param $id
     *
     * @return int
     */
    public function getDesire($typeId, $id) {
        return $this->getTotalBuyOrders($typeId, $id) - $this->getTotalSellOrders($typeId, $id);
    }


    /**
     * note: gather all buy orders in the cluster.
     * @param $typeId
     * @param $id
     *
     * @return int
     */
    public function getTotalBuyOrders($typeId, $id) {
        return $this->getOrdersTransactionType(1, $typeId, $id);
    }


    /**
     * note: gather all sell orders in the cluster.
     * @param $typeId
     * @param $id
     *
     * @return int
     */
    public function getTotalSellOrders($typeId, $id) {
        return $this->getOrdersTransactionType(2, $typeId, $id);
    }


    /**
     * the private function that gets the transactions we are looking for.
     * @param $transactionTypeId
     * @param $typeId
     * @param $id
     *
     * @return int
     */
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
