<?php

namespace App\Http\Controllers;

use App\Http\Traits\WorkWithTransactions;
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
    use FindingGoods, WorkWithTransactions;

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
        $serverId  = $this->getServerId();
        $title     = "Stores";
        $storeType = "world";

        return view('stores.world', compact('storeType', 'title','serverId', 'worldId'));
    }


    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function serverIndex()
    {
        $serverId  = $this->getServerId();
        $title     = "Stores";
        $storeType = "server";
        $stores    = $this->getTransactionsUsingTitles();

        return view('stores.server', compact('stores', 'storeType', 'title','serverId'));
    }


    public function storeIndex($id)
    {
        $title     = "Store";
        $storeType = "server";
        $stores    = $this->getTransactionsOfStore($id);

        return view('stores.server', compact('stores', 'storeType', 'title'));
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
     * @param array  $array
     * @param string $goodTypeTitle
     * @param string $goodTitle
     * @param string $transactionType
     * @param        $goodData
     *
     * @return array
     */
    public function buildTrendDataArray(
        array $array,
        string $goodTypeTitle,
        string $goodTitle,
        string $transactionType,
        $goodData
    ): array {
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

        return $array;
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
            $array           = $this->buildTrendDataArray($array, $goodTypeTitle, $goodTitle, $transactionType,
                $goodData);
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
        if(! empty($good)) {
            $goodTitle       = strtolower($good->title);
            $trendData       = $trends->gatherTrends($transactionTypeId, $hoursAgo, $goodType->id, $good->id);
            $transactionType = ($transactionTypeId === 1) ? 'orders' : 'offers';
            $array           = [];
            foreach ($trendData as $goodData) {
                $array = $this->buildTrendDataArray($array, $goodTypeTitle, $goodTitle, $transactionType, $goodData);
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
        }

        return $this->convertToCollection($globalData);
    }
}
