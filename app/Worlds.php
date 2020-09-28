<?php namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Ores
 *
 * @property int                   $id
 * @property string                $title
 * @property string                $short_name
 * @property                       $system_stock_weight
 * @property int                   $server_id
 * @property int                   $type_id
 * @property                       $activeTransactions
 * @property                       $tradezones
 * @package Models
 */
class Worlds extends Model
{
    protected $table = 'worlds';
    protected $fillable = ['title', 'short_name', 'type_id', 'system_stock_weight', 'server_id'];

    public function ores() {
        $this->belongsToMany('App\Ores');
    }

    public function ingots() {
        return $this->belongsToMany('App\Ingots');
    }

    public function clusters() {
        return $this->belongsTo('App\Servers');
    }

    public function tradezones() {
        return $this->hasMany('App\TradeZones');
    }

    public function types() {
        $this->hasMany('App\ServerTypes');
    }

    public function activeTransactions() {
        return $this->hasMany('App\ActiveTransactions');
    }


    /**
     * note: this takes the active transactions for a specific thing (type of thing id and its id) in this server and looks at how many units are in trade and each ones value based on its amount traded to get an average price to list.
     * @param $typeId
     * @param $id
     *
     * @return float|int
     */
    public function listedValue($typeId, $id) {
        $avgValue = $totalValue = 0;
        $totalBeingTraded =  0;
        $transactions = $this->activeTransactions;

        foreach($transactions as $transaction) {
            if($transaction->goods_type_id == $typeId && $transaction->goods_id == $id) {
                $totalBeingTraded += $transaction->amount;
                $totalValue += $transaction->value*$transaction->amount;
            }

        }
        if($totalValue > 0) {
            $avgValue = $totalValue/$totalBeingTraded;
        }

        return $avgValue;
    }


    /**
     * note: the desire of the cluster for a specific thing (type of thing id and its id) in the server. Where desire is expressed as the total trades buying a thing minus those selling the thing.
     * @param $typeId
     * @param $id
     *
     * @return int
     */
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
