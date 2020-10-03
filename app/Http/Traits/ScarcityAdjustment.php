<?php namespace App\Http\Traits;

use App\Http\Controllers\Stores;
use App\Models\Trends;
use App\Models\Servers;
use Carbon\Carbon;
use \Session;

trait ScarcityAdjustment
{
    /**
     *
     * @return float|int
     */
    public function getScarcityAdjustedValue()
    {
        $server     = Servers::find(Session::get('serverId'));
        $scarcityId = $server->scarcity_id ?? 1;
        switch ($scarcityId) {
            case 2 :
                $keenStoreAdjustedValue = $this->getKeenStoreAdjustedValue();
                $totalWorlds            = $this->worlds->count();
                $scarcityAdjustment     = $this->getWorldsScarcityAdjustment($totalWorlds);
                $return                 = $keenStoreAdjustedValue * (2 - ($scarcityAdjustment / ($totalWorlds * 10)));
                break;
            default :
                $return = $this->getTransactionScarcityAdjustment($server->magicNumbers);
        }

        return $return;
    }


    private function getTransactionScarcityAdjustment($magicNumbers)
    {
        $serverDemandWeight = $this->getDemandWeight('server');
        $worldDemandWeight  = $this->getDemandWeight('world');
        $storeDemandWeight  = $this->getDemandWeight('store');

        //todo: move the next 3 into getStoresAmount and return once like the 3 above
        $serverAmount                   = (object)[
            'offers' => $this->getGoodAmount(2),
            'orders' => $this->getGoodAmount(1)
        ];
        $worldAmount                    = (object)[
            'offers' => $this->getGoodAmount(2),
            'orders' => $this->getGoodAmount(1)
        ];
        $serverAverageOffersPrice       = $this->getAveragePrice(2);
        $worldAverageOffersPrice        = $this->getAveragePrice(2);
        $storeAverageOffersPrice        = ($serverAverageOffersPrice + $worldAverageOffersPrice / 2);
        $baseWeightforWorld             = $magicNumbers->base_weight_for_world_stock;
        $baseWeightForServer            = $magicNumbers->weight_for_other_world_stock;
        $baseWeightForStore             = $magicNumbers->local_store_weight;
        $weightBoost                    = $baseWeightForServer + $baseWeightforWorld + $baseWeightForStore;
        $serverWeightedAvgOfferPrice    = $serverAverageOffersPrice * $baseWeightForServer * $serverDemandWeight;
        $worldWeightedAverageOfferPrice = $worldAverageOffersPrice * $baseWeightforWorld * $worldDemandWeight;
        $storeWeightedAverageOfferPrice = $storeAverageOffersPrice * $baseWeightForStore * $storeDemandWeight;

        return $this->fianlScarcityAdjustment($serverWeightedAvgOfferPrice, $worldWeightedAverageOfferPrice,
            $storeWeightedAverageOfferPrice, $weightBoost);
    }


    private function fianlScarcityAdjustment($serverPrice, $worldPrice, $storePrice, $weightBoost)
    {
        $scarcityCost = ($serverPrice + $worldPrice + $storePrice) / $weightBoost;
        $baseCost     = $this->getBaseValue();

        return ($baseCost > $scarcityCost) ? $baseCost : $scarcityCost;
    }


    /**
     * @param $level
     * note: if there is a demand the return will be > 1.  If theres a surplus the weight will be < 1.
     *
     * @return float|int
     */
    public function getDemandWeight($level)
    {
        $order = $this->getGoodAmount(1);
        $offer = $this->getGoodAmount(2);

        return $this->calcDemand($level, $order, $offer);
    }


    /**
     * @param int $transactionTypeId
     * @param int $hours
     *
     * @return int|mixed
     */
    private function getGoodAmount(int $transactionTypeId, int $hours = 12)
    {
        $goodTypeId = $this->getGoodTypeId();

        return ($goodTypeId)
            ? 0
            : Trends::where('transaction_type_id', $transactionTypeId)
                    ->where('good_type_id', $goodTypeId)
                    ->where('good_id', $this->id)
                    ->where('dated_at', '>=', Carbon::now()->subHours($hours))
                    ->sum('amount');
    }


    private function getAveragePrice(int $transactionTypeId, int $hours = 12)
    {
        $goodTypeId = $this->getGoodTypeId();

        return ($goodTypeId)
            ? 0
            : Trends::where('transaction_type_id', $transactionTypeId)
                    ->where('good_type_id', $goodTypeId)
                    ->where('good_id', $this->id)
                    ->where('dated_at', '>=', Carbon::now()->subHours($hours))
                    ->average('average');
    }


    /**
     * @return false|int
     */
    private function getGoodTypeId()
    {
        $goodTypeId = false;
        switch (get_class($this)) {
            case 'App\Models\Ores' :
                $goodTypeId = 1;
                break;
            case 'App\Models\Ingots' :
                $goodTypeId = 2;
                break;
            case 'App\Models\Components' :
                $goodTypeId = 3;
                break;
            case 'App\Models\Tools' :
                $goodTypeId = 4;
                break;
        }

        return $goodTypeId;
    }


    /**
     * note: At the store level we check if there are more orders then offers in the store.
     *
     * @param $level
     * @param $totalOrders
     * @param $totalOffers
     *
     * @return float|int
     */
    private function calcDemand($level, $totalOrders, $totalOffers)
    {
        switch ($level) {
            case 'store':
                $demand = ($totalOrders - $totalOffers < 0) ? 1 : .5;
                break;
            default:
                if ($totalOrders === 0) {
                    $demand = 1;
                } elseif ($totalOffers === 0) {
                    $demand = 1.5;
                } else {
                    $demand = $totalOrders / $totalOffers;
                }
        }

        return $demand;
    }


    /**
     * @param $totalServers
     * note: ores are the basic building blocks so they don't look at how many ingots etc are out there versus the raw
     * ore.
     *
     * @return float|int
     */
    public function getWorldsScarcityAdjustment($totalServers)
    {
        $planetsWith         = $this->getPlanets();
        $asteroidsWith       = $this->getAsteroids();
        $totalServersWithOre = $planetsWith + $asteroidsWith;

        return ($totalServersWithOre === $totalServers) ? $totalServers * 10
            : ($planetsWith * 10) + ($asteroidsWith * 5);
    }
}
