<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Servers
 *
 * @property int                   $id
 * @property string                $title
 * @property                       $scarcity_id
 * @property                       $economy_ore_id
 * @property                       $economy_stone_modifier
 * @property                       $scaling_modifier
 * @property                       $economy_ore_value
 * @property                       $asteroid_scarcity_modifier
 * @property                       $base_modifier
 * @property                       $planet_scarcity_modifier
 * @property                       $short_name
 * @property                       $ores
 * @property                       $ingots
 * @property                       $servers
 * @property                       $info
 * @property                       $activeTransactions
 * @property                       $scarcity
 * @property                       $magicNumbers
 * @package App
 */
class Servers extends Model
{
    protected $table = 'servers';
    protected $fillable = ['title', 'scarcity_id', 'economy_ore_id', 'economy_stone_modifier', 'scaling_modifier', 'economy_ore_value','asteroid_scarcity_modifier','planet_scarcity_modifier','base_modifier', 'short_name'];

    /**
     * note: this is all the ores in the cluster
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function ores() {
        return $this->belongsToMany('App\Models\Ores');
    }


    /**
     * note: this is all the ingots in the cluster.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function ingots() {
        return $this->belongsToMany('App\Models\Ingots');
    }


    /**
     * note: this is all the servers in the cluster.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function worlds() {
        return $this->hasMany('App\Models\Worlds', 'server_id');
    }


    /**
     * note: this is all the information an admin wants to show.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function information() {
        return $this->hasMany('App\Models\Information', 'server_id');
    }


    /**
     * note: this is all the rules an admin wants to show.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rules() {
        return $this->hasMany('App\Models\Rules', 'server_id');
    }


    /**
     * note: this is all the gpses an admin wants to show.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function gps() {
        return $this->hasMany('App\Models\Gps', 'server_id');
    }


    /**
     * note: this is all the special commands an admin wants to show.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function commands() {
        return $this->hasMany('App\Models\Commands', 'server_id');
    }


    /**
     * note: this is all the mods the server uses.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mods() {
        return $this->hasMany('App\Models\Mods', 'server_id');
    }


    /**
     * note: this is all the mods the server uses.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notes() {
        return $this->hasMany('App\Models\Notes', 'server_id');
    }


    /**
     * note: the economyOre is the basic foundation of the economy. It can be any ore (including say a "credit" ore) it just gives us somethign to pin the movements against.
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function economyOre() {
        return $this->hasOne('App\Models\Ores', 'id', 'economy_ore_id');
    }


    public function scarcity() {
        return $this->hasOne('App\Models\Scarcity', 'id', 'scarcity_id');
    }

    /**
     * note: ratios is what a server admin wants the distrubution of worlds to be like.
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function ratio() {
        return $this->hasOne('App\Models\Ratios', 'id', 'id');
    }


    public function magicNumbers() {
        return $this->hasOne('App\Models\MagicNumbers', 'server_id', 'id');
    }


    /**
     * note: this is all the current transactions in the cluster.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function activeTransactions() {
        return $this->hasMany('App\Models\ActiveTransactions');
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


    public function getWorldsRarityTotals() {
        $worldsRarityCount = [];
        $collection = $this->worlds()->groupBy('rarity_id')
                               ->selectRaw('count(*) as total, rarity_id as id')
                               ->get();
        foreach($collection as $rarity) {
            $worldsRarityCount[$rarity->id] = ['title' => Rarity::find($rarity->id)->title, 'total' => $rarity->total];
        }


        return collect($worldsRarityCount);
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
