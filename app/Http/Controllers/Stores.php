<?php

namespace App\Http\Controllers;

use App\Models\GoodTypes;
use App\Http\Traits\FindingGoods;
use App\Models\TradeZones;
use App\Models\Transactions;
use \Illuminate\Support\Collection;

Collection::macro('sortByDate', function ($column = 'created_at', $order = SORT_DESC) {
    /* @var $this Collection */
    return $this->sortBy(function ($datum) use ($column) {
        return strtotime($datum->$column);
    }, SORT_REGULAR, $order == SORT_DESC);
});

class Stores extends Controller
{
    use FindingGoods;

    protected $data;
    protected $ownerStoreData;


    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $hoursWindow = 12;
        $title       = "Stores";
        $storeType   = "personal";
        $stores      = $this->getTransactionsOfOwner();

        return view('stores.personal', compact('stores', 'storeType', 'title', 'hoursWindow'));
    }


    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function worldIndex()
    {
        $worldId   = $this->getWorldId();
        $title     = "Stores";
        $storeType = "world";
        $stores    = $this->getTransactionsUsingTitles($worldId);

        return view('stores.world', compact('stores', 'storeType', 'title'));
    }


    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function serverIndex()
    {
        $title     = "Stores";
        $storeType = "server";
        $stores    = $this->getTransactionsUsingTitles();

        return view('stores.server', compact('stores', 'storeType', 'title'));
    }


    public function storeIndex($id)
    {
        $title     = "Store";
        $storeType = "server";
        $stores    = $this->getTransactionsOfStore($id);

        return view('stores.server', compact('stores', 'storeType', 'title'));
    }


    /**
     * note: this gets all the transactions for the stores and returns it with the ids converted to titles.
     *
     * @param null|int $worldId
     *
     * @return \Illuminate\Support\Collection
     */
    public function getTransactionsUsingTitles($worldId = null)
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
     * note: this gets all the transactions for a given owners stores and returns it with the ids converted to titles.
     *
     *
     * @return \Illuminate\Support\Collection
     */
    public function getTransactionsOfOwner()
    {
        $owner                = \Auth::user()->server_username;
        $serverId             = $this->getServerId();
        $worldId              = $this->getWorldId();

        $this->ownerStoreData = [];
        $transactionsModel    = new Transactions();
        $transactions         = $transactionsModel->where('owner', $owner)
                                                  ->where('world_id', $worldId)
                                                  ->where('server_id', $serverId)
                                                  ->orderBy('good_type_id', 'ASC')
                                                  ->orderBy('transaction_type_id', 'DESC')
                                                  ->orderBy('good_id', 'DESC');
        foreach ($transactions->get() as $transaction) {
            $this->updateOwnerStoreData($transaction);
        }

        return $this->convertToCollection($this->ownerStoreData);
    }


    /**
     * note: this gets all the transactions for a given owners stores and returns it with the ids converted to titles.
     *
     * @param $tzId
     *
     * @return \Illuminate\Support\Collection
     */
    public function getTransactionsOfStore($tzId)
    {
        $this->ownerStoreData = [];
        $transactionsModel    = new Transactions();
        $transactions         = $transactionsModel->where('trade_zone_id', $tzId)
                                                  ->orderBy('good_type_id', 'ASC')
                                                  ->orderBy('transaction_type_id', 'DESC')
                                                  ->orderBy('good_id', 'DESC');
        foreach ($transactions->get() as $transaction) {
            $this->updateOwnerStoreData($transaction);
        }
        $rows = $this->condenseData($this->ownerStoreData);

        return $this->convertToCollection($rows);
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
     * @param $transaction
     */
    private function updateOwnerStoreData($transaction)
    {
        $tradeZone = TradeZones::find($transaction->trade_zone_id);
        $this->updateGridInfo($transaction, $tradeZone);
        $this->updateTransactionData($transaction, $tradeZone);
    }


    private function updateTransactionData($transaction, $tradeZone)
    {
        $goodType        = GoodTypes::find($transaction->good_type_id);
        $good            = $this->getGoodFromGoodTypeAndGoodId($goodType, $transaction->good_id);
        $transactionType = $this->getTransactionTypeFromId($transaction->transaction_type_id);
        $transactionType = ($transactionType->title === 'buy') ? 'Orders' : 'Offers';
        $price           = $transaction->value;
        $amount          = $transaction->amount;
        $goodTypeTitle   = $goodType->title;
        $goodTypeId      = $goodType->id;
        $goodTitle       = $good->title;
        $goodId          = $good->id;
        $gridName        = $tradeZone->title;
        $serverId        = $this->getServerId();
        if ($goodType->count() > 0 && $good->count() > 0) {
            if (empty($this->ownerStoreData[$gridName]['goods'][$goodTypeTitle][$goodTitle][$transactionType])) {
                $this->ownerStoreData[$gridName]['goods'][$goodTypeTitle][$goodTitle][$transactionType] = [
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
            $this->ownerStoreData[$gridName]['goods'][$goodTypeTitle][$goodTitle][$transactionType]['count']++;
            $this->ownerStoreData[$gridName]['goods'][$goodTypeTitle][$goodTitle][$transactionType]['amount']   += $amount;
            $this->ownerStoreData[$gridName]['goods'][$goodTypeTitle][$goodTitle][$transactionType]['sum']      += $price * $amount;
            $averagePrice                                                                                       = ($amount <= 0)
                ? 0
                : $this->ownerStoreData[$gridName]['goods'][$goodTypeTitle][$goodTitle][$transactionType]['sum'] / $this->ownerStoreData[$gridName]['goods'][$goodTypeTitle][$goodTitle][$transactionType]['amount'];
            $this->ownerStoreData[$gridName]['goods'][$goodTypeTitle][$goodTitle][$transactionType]['avgPrice'] = $averagePrice;
            if ($this->ownerStoreData[$gridName]['goods'][$goodTypeTitle][$goodTitle][$transactionType]['minPrice'] === 0 || $this->ownerStoreData[$gridName]['goods'][$goodTypeTitle][$goodTitle][$transactionType]['minPrice'] > $price) {
                $this->ownerStoreData[$gridName]['goods'][$goodTypeTitle][$goodTitle][$transactionType]['minPrice'] = $price;
            }
            if ($this->ownerStoreData[$gridName]['goods'][$goodTypeTitle][$goodTitle][$transactionType]['maxPrice'] < $price) {
                $this->ownerStoreData[$gridName]['goods'][$goodTypeTitle][$goodTitle][$transactionType]['maxPrice'] = $price;
            }
        }
    }


    /**
     * @param $transaction
     * @param $tradeZone
     */
    private function updateGridInfo($transaction, $tradeZone)
    {
        $gridName = $tradeZone->title;
        if (empty($this->ownerStoreData[$gridName])) {
            $this->ownerStoreData[$gridName]['owner'] = $transaction->owner;
            $this->ownerStoreData[$gridName]['GPS']   = $tradeZone->gps;
            $this->ownerStoreData[$gridName]['jsid']  = $this->cleanJsName($gridName);
            $this->ownerStoreData[$gridName]['tzid']  = $tradeZone->id;
        }
    }


    /**
     * @param int $hoursAgo
     *
     * @return \Illuminate\Support\Collection
     */
    private function getGlobalAveragesForGoods($hoursAgo = 12)
    {
        //todo: to actually limit to a personal/world/server levels we will have to refactor how we get the data
        $globalAverages    = [];
        $transactionTypeId = 0; //override to get all goods
        $trends            = new Trends();
        $trendData         = $trends->gatherTrends($transactionTypeId, $hoursAgo);
        $array             = [];
        foreach ($trendData as $goodData) {
            $goodTitle       = $goodData->title;
            $goodType        = GoodTypes::find($goodData->good_type_id);
            $goodTypeTitle   = strtolower($goodType->title);
            $transactionType = ($goodData->transaction_type_id === 1) ? 'orders' : 'offers';
            if (empty($array[$goodTypeTitle][$goodTitle][$transactionType])) {
                $array[$goodTypeTitle][$goodTitle][$transactionType] = [
                    'sum'     => 0,
                    'amount'  => 0,
                    'average' => 0,
                    'count'   => 0
                ];
            }
            $array[$goodTypeTitle][$goodTitle][$transactionType]['sum']     += $goodData->sum;
            $array[$goodTypeTitle][$goodTitle][$transactionType]['amount']  += $goodData->amount;
            $array[$goodTypeTitle][$goodTitle][$transactionType]['average'] = ($array[$goodTypeTitle][$goodTitle][$transactionType]['amount'] == 0)
                ? 0
                : $array[$goodTypeTitle][$goodTitle][$transactionType]['sum'] / $array[$goodTypeTitle][$goodTitle][$transactionType]['amount'];
            $array[$goodTypeTitle][$goodTitle][$transactionType]['count']++;
        }

        foreach ($array as $goodTypeTitle => $goodTypeData) {
            foreach ($goodTypeData as $goodTitle => $goodData) {
                foreach ($goodData as $transactionTitle => $transactionData) {
                    $globalAverages[] = [
                        'transactionType' => $transactionTitle,
                        'goodType'        => $goodTypeTitle,
                        'title'           => $goodTitle,
                        'average'         => $transactionData['average'],
                        'amount'          => $transactionData['amount']
                    ];
                }
            }
        }

        return $this->convertToCollection($globalAverages);
    }


    /**
     * @param int $transactionTypeId
     * @param     $goodTypeId
     * @param     $goodId
     * @param int $hoursAgo
     *
     * @return \Illuminate\Support\Collection
     */
    public function getGlobalDataForGood(int $transactionTypeId, $goodTypeId, $goodId, int $hoursAgo = 12)
    {
        //todo: to actually limit to a personal/world/server levels we will have to refactor how we get the data
        $globalData      = [];
        $trends          = new Trends();
        $goodType        = (is_int($goodTypeId)) ? GoodTypes::find($goodTypeId)
            : GoodTypes::where('title', ucfirst($goodTypeId))->first();
        $goodTypeTitle   = strtolower($goodType->title);
        $good            = (is_int($goodId)) ? $this->getGoodFromGoodTypeAndGoodId($goodType, $goodId)
            : $this->getGoodFromGoodTypeAndGoodTitle($goodType, $goodId);
        $goodTitle       = strtolower($good->title);
        $trendData       = $trends->gatherTrends($transactionTypeId, $hoursAgo, $goodType->id, $good->id);
        $transactionType = ($transactionTypeId === 1) ? 'orders' : 'offers';
        $array           = [];
        foreach ($trendData as $goodData) {
            if (empty($array[$goodTypeTitle][$goodTitle][$transactionType])) {
                $array[$goodTypeTitle][$goodTitle][$transactionType] = [
                    'sum'     => 0,
                    'amount'  => 0,
                    'average' => 0,
                    'count'   => 0
                ];
            }
            $array[$goodTypeTitle][$goodTitle][$transactionType]['sum']     += $goodData->sum;
            $array[$goodTypeTitle][$goodTitle][$transactionType]['amount']  += $goodData->amount;
            $array[$goodTypeTitle][$goodTitle][$transactionType]['average'] = ($array[$goodTypeTitle][$goodTitle][$transactionType]['amount'] == 0)
                ? 0
                : $array[$goodTypeTitle][$goodTitle][$transactionType]['sum'] / $array[$goodTypeTitle][$goodTitle][$transactionType]['amount'];
            $array[$goodTypeTitle][$goodTitle][$transactionType]['count']++;
        }

        foreach ($array as $goodTypeTitle => $goodTypeData) {
            foreach ($goodTypeData as $goodTitle => $goodData) {
                foreach ($goodData as $transactionTitle => $transactionData) {
                    $globalData[] = [
                        'transactionType' => $transactionTitle,
                        'goodType'        => $goodTypeTitle,
                        'title'           => $goodTitle,
                        'average'         => $transactionData['average'],
                        'amount'          => $transactionData['amount']
                    ];
                }
            }
        }

        return $this->convertToCollection($globalData);
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
     * @param $gridName
     *
     * @return string
     */
    private function cleanJsName($gridName)
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


    //todo::find a better way then session for deciding the active server
    private function getServerId()
    {
        return (empty(\Session::get('serverId'))) ? 1 : \Session::get('serverId');
    }


    //todo::find a better way then session for deciding the active world
    private function getWorldId()
    {
        return (empty(\Session::get('worldId'))) ? 1 : \Session::get('worldId');
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

            $distance = (($remotex - $localx) ^ 2 + (($remotey - $localy) ^ 2) + ($remotez - $localz) ^ 2) ^ (1 / 2);

            return (abs($distance) > $minimumDistance) ? abs($distance) : 0;
        } else {
            return 0;
        }
    }
}
