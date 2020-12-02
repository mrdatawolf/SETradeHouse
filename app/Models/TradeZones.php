<?php namespace App\Models;

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
 * @property                       $worlds
 * @property                       $activeTransactions
 * @property                       $gps
 * @package Models
 */
class TradeZones extends Model
{
    protected $connection   ='main';
    public $table       = 'trade_zones';
    public $timestamps  = false;
    public $fillable    = ['title', 'owner', 'server_id', 'world_id', 'local_weight', 'gps'];

    public function worlds() {
        return $this->belongsTo(Worlds::class);
    }

    public function servers() {
        return $this->belongsTo(Servers::class);
    }

    public function transactions() {
        return $this->hasMany(Transactions::class);
    }

    public function latestTransaction() {
        return $this->hasOne(Transactions::class)->latest();
    }


    /**
     * note: this takes the active transactions for a specific thing (type of thing id and its id) in the cluster (cluster id) and looks at how many units are in trade and each ones value based on its amount traded to get an average price to list.
     * @param $clusterId
     * @param $typeId
     * @param $id
     *
     * @return float|int
     */
    public function listedValue($clusterId, $typeId, $id) {
        $avgValue = $totalValue = 0;
        $totalBeingTraded =  0;
        $transactions = $this->activeTransactions;

        foreach($transactions as $transaction) {
            if($transaction->clusters_id == $clusterId && $transaction->goods_type_id == $typeId && $transaction->goods_id == $id) {
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
     * note: the desire of the cluster for a specific thing (type of thing id and its id) in the cluster (cluster id). Where desire is expressed as the total trades buying a thing minus those selling the thing.
     * @param $clusterId
     * @param $typeId
     * @param $id
     *
     * @return int
     */
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
