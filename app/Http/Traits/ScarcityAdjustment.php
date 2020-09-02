<?php namespace App\Http\Traits;

use App\Servers;
use \Session;

trait ScarcityAdjustment
{
    /**
     *
     * @return float|int
     */
    public function getScarcityAdjustedValue() {
        $keenStoreAdjustedValue = $this->getKeenStoreAdjustedValue();
        $server                 = Servers::find(Session::get('serverId'));
        $scarcityId             = $server->scarcity_id ?? 1;
        switch($scarcityId) {
            case 2 :
                $totalWorlds = $this->worlds->count();
                $scarcityAdjustment = $this->getWorldsScarcityAdjustment($totalWorlds);
                $return = $keenStoreAdjustedValue*(2-($scarcityAdjustment/($totalWorlds*10)));
                break;
            default :
                $return = $this->getTransactionScarcityAdjustment($server->magicNumbers);
        }

        return $return;
    }

    private function getTransactionScarcityAdjustment($magicNumbers) {
        $serverDemandWeight             = $this->getDemandWeight('server');
        $worldDemandWeight              = $this->getDemandWeight('world');
        $storeDemandWeight              = $this->getDemandWeight('store');
        $serverSumPrices                = $this->getStoresSumPrice('server');
        $worldSumPrices                 = $this->getStoresSumPrice('world');
        //todo: move the next 3 into getStoresAmount and return once like the 3 above
        $serverAmount                   = (object) ['offers' =>$this->getStoresAmount('store', 'offers'), 'orders' => $this->getStoresAmount('store', 'orders')];
        $worldAmount                    = (object) ['offers' =>$this->getStoresAmount('store', 'offers'), 'orders' => $this->getStoresAmount('store', 'orders')];
        $serverAverageOffersPrice       = (! empty($serverAmount->offers)) ? $serverSumPrices->offers/$serverAmount->offers : 0;
        $worldAverageOffersPrice        = (! empty($worldAmount->offers)) ? $worldSumPrices->offers/$worldAmount->offers : 0;
        $storeAverageOffersPrice        = ($serverAverageOffersPrice+$worldAverageOffersPrice/2);
        $baseWeightforWorld             = $magicNumbers->base_weight_for_world_stock;
        $baseWeightForServer            = $magicNumbers->weight_for_other_world_stock;
        $baseWeightForStore             = $magicNumbers->local_store_weight;
        $numberPlusWeightBoost          = $baseWeightForServer+$baseWeightforWorld+$baseWeightForStore;
        $serverWeightedAvgOfferPrice    = $serverAverageOffersPrice*$baseWeightForServer*$serverDemandWeight;
        $worldWeightedAverageOfferPrice = $worldAverageOffersPrice*$baseWeightforWorld*$worldDemandWeight;
        $storeWeightedAverageOfferPrice = $storeAverageOffersPrice*$baseWeightForStore*$storeDemandWeight;

        return ($serverWeightedAvgOfferPrice + $worldWeightedAverageOfferPrice + $storeWeightedAverageOfferPrice)/$numberPlusWeightBoost;
    }

    /**
     * @param $level
     * note: if there is a demand the return will be > 1.  If theres a surplus the weight will be < 1.
     *
     * @return float|int
     */
    public function getDemandWeight($level) {
        $offer  = $this->getStoresAmount($level, 'offers');
        $order  = $this->getStoresAmount($level, 'orders');

        return $this->calcDemand($level, $order, $offer);
    }


    /**
     * @param $level
     * @param $transaction
     *
     * @return int|mixed
     */
    private function getStoresAmount($level, $transaction) {
        $stores = Session::get('stores');
        $amount  = 0;
        switch(get_class($this)) {
            case 'App\Ores' :
                $itemModel = 'Ores';
                break;
            case 'App\Ingots' :
                $itemModel = 'Ingots';
                break;
            case 'App\Components' :
                $itemModel = 'Components';
                break;
        }
        if(! empty($stores)) {
            switch ($level) {
                case 'server':
                case 'world' :
                case 'store' :
                    foreach ($stores as $store => $storeTotals) {
                        $amount += $storeTotals['Totals'][$itemModel][ucfirst($transaction)][ucfirst($this->title)]['Amount'] ?? 0;
                    }
            }
        }

        return $amount;
    }


    private function getStoresSumPrice($level) {
        $offer = $this->getStoresTransactionSumPrice($level, 'offers');
        $order = $this->getStoresTransactionSumPrice($level, 'orders');

        return (object) ['offers' => $offer, 'orders' => $order];
    }


    /**
     * @param $level
     * @param $transaction
     *
     * @return int|mixed
     */
    private function getStoresTransactionSumPrice($level, $transaction) {
        $stores = Session::get('stores');
        $sumPrice    = 0;
        switch(get_class($this)) {
            case 'App\Ores' :
                $itemModel = 'Ores';
                break;
            case 'App\Ingots' :
                $itemModel = 'Ingots';
                break;
            case 'App\Components' :
                $itemModel = 'Components';
                break;
        }

        if(! empty($stores)) {
            switch ($level) {
                case 'server':
                case 'world' :
                case 'store' :
                    foreach ($stores as $store => $storeTotals) {
                        $sumPrice += $storeTotals['Totals'][$itemModel][ucfirst($transaction)][ucfirst($this->title)]['Price'] ?? 0;
                    }
            }
        }

        return $sumPrice;
    }


    /**
     * note: At the store level we check if there are more orders then offers in the store.
     * @param $level
     * @param $totalOrders
     * @param $totalOffers
     *
     * @return float|int
     */
    private function calcDemand($level, $totalOrders, $totalOffers) {
        switch($level) {
            case 'store':
                $demand = ($totalOrders-$totalOffers < 0) ? 1 : .5;
                break;
            default:
                if($totalOrders === 0) {
                    $demand = 1;
                } elseif($totalOffers === 0) {
                    $demand = 1.5;
                } else {
                    $demand = $totalOrders/$totalOffers;
                }
        }


        return $demand;
    }


    /**
     * @param $totalServers
     * note: ores are the basic building blocks so they don't look at how many ingots etc are out there versus the raw ore.
     *
     * @return float|int
     */
    public function getWorldsScarcityAdjustment($totalServers) {
        $planetsWith = $this->getPlanets();
        $asteroidsWith = $this->getAsteroids();
        $totalServersWithOre = $planetsWith+$asteroidsWith;

        return ($totalServersWithOre === $totalServers) ? $totalServers*10 : ($planetsWith * 10) + ($asteroidsWith * 5);
    }
}
