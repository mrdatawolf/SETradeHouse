<?php namespace App\Http\Traits;


use App\Models\Ammo;
use App\Models\Bottles;
use App\Models\Components;
use App\Models\GoodTypes;
use App\Models\Ingots;
use App\Models\Ores;
use App\Models\Tools;
use App\Models\TradeZones;
use App\Models\Transactions;

trait WorkWithTransactions {
    protected array $data;


    /**
     * @param $gridName
     *
     * @return string
     */
    private function cleanJsName($gridName): string
    {
        $idName = str_replace(' ', '', $gridName);
        $idName = str_replace('[', '', $idName);
        $idName = str_replace(']', '', $idName);
        $idName = str_replace('(', '', $idName);
        $idName = str_replace(')', '', $idName);
        $idName = htmlentities($idName);

        return htmlspecialchars($idName);
    }

    /**
     * note: this gets all the transactions for the stores and returns it with the ids converted to titles.
     *
     * @param int|null $worldId
     *
     * @return \Illuminate\Support\Collection
     */
    public function getTransactionsUsingTitles( $worldId = null)
    {
        $serverId  = $this->getServerId();
        $this->data   = [];
        $transactions = new Transactions();

        if ($worldId) {
            $transactions->where('world_id', $worldId)
                         ->orderBy('good_type_id', 'ASC')
                         ->orderBy('transaction_type_id', 'DESC')
                         ->orderBy('good_id', 'DESC')
                         ->chunk(400, function ($transactions) use($serverId) {
                             foreach ($transactions as $transaction) {
                                 $this->updateData($transaction, $serverId);
                             }
                         });
        } else {
            $transactions->orderBy('good_type_id', 'ASC')
                         ->orderBy('transaction_type_id', 'DESC')
                         ->orderBy('good_id', 'DESC')
                         ->chunk(400, function ($transactions) use($serverId) {
                             foreach ($transactions as $transaction) {
                                 $this->updateData($transaction, $serverId);
                             }
                         });
        }
        $rows = $this->condenseData($this->data);

        return $this->convertToCollection($rows);
    }


    /**
     * note: condensing it to show useful row data.
     *
     * @param $data
     *
     * @return array
     */
    public function condenseData($data)
    {
        $rows = [];
        foreach ($data as $gridName => $gridData) {
            $rows[$gridName]['owner'] = $gridData['owner'];
            $rows[$gridName]['GPS']   = $gridData['GPS'];
            $rows[$gridName]['jsid']  = $gridData['jsid'];
            $rows[$gridName]['tzid']  = $gridData['tzid'];
            foreach ($gridData['goods'] as $goodType => $goodTypeData) {
                foreach ($goodTypeData as $good => $goodData) {
                    $localOrders         = $goodData['Orders'] ?? null;
                    $localOffers         = $goodData['Offers'] ?? null;
                    $localOrderPrice = (empty($localOrders['avgPrice'])) ? 0 : $localOrders['avgPrice'];
                    $localOrderAmount    = (empty($localOrders['amount'])) ? 0 : $localOrders['amount'];
                    $localOfferAmount    = (empty($localOffers['amount'])) ? 0 : $localOffers['amount'];
                    $localOfferPrice  = (empty($localOffers['avgPrice'])) ? 0 : $localOffers['avgPrice'];
                    $offerAmount    = (empty($localOffers['amount'])) ? 0 : $localOffers['amount'];

                    if (empty($localOrders)) {
                        $bestOrderFromPrice           = 0;
                        $bestOrderFromAmount          = 0;
                        $bestAvailableOrderFromAmount = 0;
                        $orderFromTradeZone           = 'n/a';
                    } else {
                        $orderGoodId                  = $localOrders['goodId'];
                        $orderGoodTypeId              = $localOrders['goodTypeId'];
                        $orderServerId                = $localOrders['serverId'];
                        $bestOrderFrom                = $this->getLowestOfferForGoodOnServer($orderGoodId,
                            $orderGoodTypeId, $orderServerId, $rows[$gridName]['tzid']);
                        $bestOrderFromPrice           = (empty($bestOrderFrom->get('value'))) ? 0
                            : (int)$bestOrderFrom->get('value');
                        $bestOrderFromAmount          = (empty($bestOrderFrom->get('amount'))) ? 0
                            : (int)$bestOrderFrom->get('amount');
                        $bestAvailableOrderFromAmount = ($bestOrderFromAmount < $localOrderAmount) ? $bestOrderFromAmount
                            : $localOrderAmount;
                        $orderFromTradeZone           = TradeZones::find($bestOrderFrom->get('trade_zone_id'));
                    }
                    if (empty($localOffers)) {
                        $bestOfferToPrice           = 0;
                        $bestOfferToAmount          = 0;
                        $bestAvailableOfferToAmount = 0;
                        $offerToTradeZone           = 'n/a';
                    } else {
                        $offerGoodId                = $localOffers['goodId'];
                        $offerGoodTypeId            = $localOffers['goodTypeId'];
                        $offerServerId              = $localOffers['serverId'];
                        $bestOfferTo                = $this->getHighestOrderForGoodOnServer($offerGoodId,
                            $offerGoodTypeId, $offerServerId, $rows[$gridName]['tzid']);
                        $bestOfferToPrice           = (empty($bestOfferTo->get('value'))) ? 0
                            : (int)$bestOfferTo->get('value');
                        $bestOfferToAmount          = (empty($bestOfferTo->get('amount'))) ? 0
                            : (int)$bestOfferTo->get('amount');
                        $bestAvailableOfferToAmount = ($bestOfferToAmount < $localOfferAmount) ? $bestOfferToAmount
                            : $localOrderAmount;
                        $offerToTradeZone           = TradeZones::find($bestOfferTo->get('trade_zone_id'));
                    }
                    //leaving this checkpoint here. it's a good way to limit the data in debuging
                    //if($goodType === 'Ammo') {
                    //if($gridName === "Fallingwater" && $good === 'magnesium' && $goodType === 'Ammo') {
                    //dd($bestOfferTo, $bestOfferToAmount, $localOfferAmount);
                    //}
                    $orderFromProfitRaw                         = ($localOrderPrice - $bestOrderFromPrice) * $bestAvailableOrderFromAmount;
                    $orderFromProfit                            = ($orderFromProfitRaw > 0) ? $orderFromProfitRaw : 0;
                    $orderFromDistance                          = $this->getDistanceByGPS($gridData['GPS'],
                        $orderFromTradeZone);
                    $offerToProfitRaw                           = ($bestOfferToPrice - $localOfferPrice) * $bestAvailableOfferToAmount;
                    $offerToProfit                              = ($offerToProfitRaw > 0) ? $offerToProfitRaw : 0;
                    $offerToDistance                            = $this->getDistanceByGPS($gridData['GPS'],
                        $offerToTradeZone);
                    $row                                        = [
                        'store'     => [
                            'orders' => [
                                'avgPrice' => (empty($localOrderPrice)) ? 0 : $localOrderPrice,
                                'amount'   => (empty($localOrderAmount)) ? 0 : $localOrderAmount
                            ],
                            'offers' => [
                                'avgPrice' => (empty($localOfferPrice)) ? 0 : $localOfferPrice,
                                'amount'   => (empty($offerAmount)) ? 0 : $offerAmount
                            ]
                        ],
                        'orderFrom' => [
                            'tradeZoneTitle' => $orderFromTradeZone->title ?? 'n/a',
                            'bestValue'      => (empty($bestOrderFromPrice)) ? 0 : $bestOrderFromPrice,
                            'bestAmount'     => (empty($bestOrderFromAmount)) ? 0 : $bestOrderFromAmount,
                            'profit'         => empty($orderFromProfit) ? 0 : $orderFromProfit,
                            'distance'       => $orderFromDistance,
                        ],
                        'offerTo'   => [
                            'tradeZoneTitle' => $offerToTradeZone->title ?? 'n/a',
                            'bestValue'      => $bestOfferToPrice ?? 0,
                            'bestAmount'     => $bestOfferToAmount ?? 0,
                            'profit'         => empty($offerToProfit) ? 0 : $offerToProfit,
                            'distance'       => $offerToDistance
                        ]

                    ];
                    $rows[$gridName]['goods'][$goodType][$good] = $row;
                }
            }
        }

        return $rows;
    }


    /**
     * @param $transaction
     */
    private function updateData($transaction, $serverId)
    {
        $tradeZone       = TradeZones::find($transaction->trade_zone_id);
        $goodType        = GoodTypes::find($transaction->good_type_id);
        $tzId            = (int)$transaction->trade_zone_id;
        $good            = $this->getGoodFromGoodTypeAndGoodId($goodType, $transaction->good_id);
        $transactionType = $this->getTransactionTypeFromId($transaction->transaction_type_id);
        $transactionType = ($transactionType->title === 'buy') ? 'Orders' : 'Offers';
        $price           = $transaction->value;
        $amount          = $transaction->amount;
        $goodTypeTitle   = $goodType->title;
        $goodTypeId      = $goodType->id;
        $goodTitle       = $good->title;
        $goodId          = $good->id;
        $gridName        = trim($tradeZone->title);

        if ($tradeZone->count() > 0 && $goodType->count() > 0 && $good->count() > 0) {
            if (empty($this->data[$gridName])) {
                $this->data[$gridName]['owner'] = $transaction->owner;
                $this->data[$gridName]['GPS']   = $tradeZone->gps;
                $this->data[$gridName]['jsid']  = $this->cleanJsName($gridName);
                $this->data[$gridName]['tzid']  = $tzId;
                $this->data[$gridName]['goods'] = [];
            }
            if (empty($this->data[$gridName]['goods'][$goodTypeTitle][$goodTitle][$transactionType])) {
                $this->data[$gridName]['goods'][$goodTypeTitle][$goodTitle][$transactionType] = [
                    'serverId'   => $serverId,
                    'goodTypeId' => $goodTypeId,
                    'goodId'     => $goodId,
                    'minPrice'   => 0,
                    'maxPrice'   => 0,
                    'amount'     => 0,
                    'sum'        => 0,
                    'avgPrice'   => 0,
                    'count'      => 0
                ];
            }
            $this->data[$gridName]['goods'][$goodTypeTitle][$goodTitle][$transactionType]['count']++;
            $this->data[$gridName]['goods'][$goodTypeTitle][$goodTitle][$transactionType]['amount']   += $amount;
            $this->data[$gridName]['goods'][$goodTypeTitle][$goodTitle][$transactionType]['sum']      += $price * $amount;
            $averagePrice                                                                             = ($amount <= 0)
                ? 0
                : $this->data[$gridName]['goods'][$goodTypeTitle][$goodTitle][$transactionType]['sum'] / $this->data[$gridName]['goods'][$goodTypeTitle][$goodTitle][$transactionType]['amount'];
            $this->data[$gridName]['goods'][$goodTypeTitle][$goodTitle][$transactionType]['avgPrice'] = $averagePrice;
            if ($this->data[$gridName]['goods'][$goodTypeTitle][$goodTitle][$transactionType]['minPrice'] === 0 || $this->data[$gridName]['goods'][$goodTypeTitle][$goodTitle][$transactionType]['minPrice'] > $price) {
                $this->data[$gridName]['goods'][$goodTypeTitle][$goodTitle][$transactionType]['minPrice'] = $price;
            }
            if ($this->data[$gridName]['goods'][$goodTypeTitle][$goodTitle][$transactionType]['maxPrice'] < $price) {
                $this->data[$gridName]['goods'][$goodTypeTitle][$goodTitle][$transactionType]['maxPrice'] = $price;
            }
        }
        $data[$gridName] = $this->data;
    }


    /**
     * @param $goodType
     * @param $goodId
     *
     * @return |null
     */
    private function getGoodFromGoodTypeAndGoodId($goodType, $goodId) {
        switch($goodType->id) {
            case '2' :
                $model = Ingots::find($goodId);
                break;
            case '1' :
                $model = Ores::find($goodId);
                break;
            case '3' :
                $model = Components::find($goodId);
                break;
            case '4' :
                $model = Tools::find($goodId);
                break;
            case '5' :
                $model = Ammo::find($goodId);
                break;
            case '6' :
                $model = Bottles::find($goodId);
                break;
            default:
                $model = Tools::find($goodId);

        }

        return (! empty($model)) ? $model : null;
    }


    /**
     * note: if currentTradeZoneId is set then it will ignore those tradezones
     *
     * @param int            $goodId
     * @param int            $goodTypeId
     * @param int            $serverId
     * @param array|int|null $currentTradeZoneId
     *
     * @return \Illuminate\Support\Collection
     */
    public function getHighestOrderForGoodOnServer(
        int $goodId,
        int $goodTypeId,
        int $serverId,
        $currentTradeZoneId = null
    ) {
        if ( ! is_array($currentTradeZoneId) && ! empty($currentTradeZoneId)) {
            $currentTradeZoneId = [$currentTradeZoneId];
        }
        if (empty($currentTradeZoneId)) {
            $bestValue = Transactions::where('server_id', $serverId)
                                     ->where('transaction_type_id', 1)
                                     ->where('good_type_id', $goodTypeId)
                                     ->where('good_id', $goodId)
                                     ->orderBy('value', 'DESC');
        } else {
            $bestValue = Transactions::where('server_id', $serverId)
                                     ->whereNotIn('trade_zone_id', $currentTradeZoneId)
                                     ->where('transaction_type_id', 1)
                                     ->where('good_type_id', $goodTypeId)
                                     ->where('good_id', $goodId)
                                     ->orderBy('value', 'DESC');
        }

        return $this->convertToCollection($bestValue->first());
    }


    /**
     * @param $data
     *
     * @return \Illuminate\Support\Collection
     */
    private function convertToCollection($data)
    {
        $json   = json_encode($data);
        $decode = json_decode($json);

        return collect($decode);
    }


    /**
     * note: if currentTradeZoneId is set then it will ignore those tradezones
     *
     * @param int            $goodId
     * @param int            $goodTypeId
     * @param int            $serverId
     * @param array|int|null $currentTradeZoneId
     *
     * @return \Illuminate\Support\Collection
     */
    public function getLowestOfferForGoodOnServer(
        int $goodId,
        int $goodTypeId,
        int $serverId,
        $currentTradeZoneId = null
    ) {
        if ( ! is_array($currentTradeZoneId) && ! empty($currentTradeZoneId)) {
            $currentTradeZoneId = [(int)$currentTradeZoneId];
        }

        if (empty($currentTradeZoneId)) {
            $bestValue = Transactions::where('server_id', $serverId)
                                     ->where('transaction_type_id', 2)
                                     ->where('good_type_id', $goodTypeId)
                                     ->where('good_id', $goodId)
                                     ->orderBy('value', 'ASC');
        } else {
            $bestValue = Transactions::where('server_id', $serverId)
                                     ->whereNotIn('trade_zone_id', $currentTradeZoneId)
                                     ->where('transaction_type_id', 2)
                                     ->where('good_type_id', $goodTypeId)
                                     ->where('good_id', $goodId)
                                     ->orderBy('value', 'ASC');
        }

        return $this->convertToCollection($bestValue->first());
    }


    /**
     * @param $localGPS
     * @param $remoteData
     *
     * @return float|int
     */
    private function getDistanceByGPS($localGPS, $remoteData)
    {
        $minimumDistance = 1000; //this is in meters
        if ($localGPS !== 'n/a' && ! empty($remoteData->gps) && $remoteData->gps !== 'n/a') {
            $remoteGPS   = $remoteData->gps;
            $localArray  = explode(':', $localGPS);
            $localx      = $localArray[2];
            $localy      = $localArray[3];
            $localz      = $localArray[4];
            $remoteArray = explode(':', $remoteGPS);
            $remotex     = $remoteArray[2];
            $remotey     = $remoteArray[3];
            $remotez     = $remoteArray[4];

            $distance = (($remotex - $localx) ^ 2 + ($remotey - $localy) ^ 2 + ($remotez - $localz) ^ 2) ^ (1 / 2);

            return ($distance > $minimumDistance) ? $distance : 0;
        } else {
            return 0;
        }
    }



    //todo::find a better way then session for deciding the active server
    protected function getServerId()
    {
        return (empty(\Session::get('serverId'))) ? 1 : \Session::get('serverId');
    }


    //todo::find a better way then session for deciding the active world
    protected function getWorldId()
    {
        return (empty(\Session::get('worldId'))) ? 1 : \Session::get('worldId');
    }
}
