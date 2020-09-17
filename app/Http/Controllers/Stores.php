<?php

namespace App\Http\Controllers;

use App\GoodTypes;
use App\Http\Traits\FindingGoods;
use App\TradeZones;
use App\Transactions;
use \Session;

class Stores extends Controller
{
    use FindingGoods;

    protected $data;


    public function index()
    {
        $title          = "Stores";
        $storeType      = "personal";
        $stores         = Session::get('stores');
        $globalAverages = $this->getGlobalAveragesForGoods('server', $stores);

        return view('stores.personal', compact('stores', 'storeType', 'title', 'globalAverages'));
    }


    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function worldIndex()
    {
        $title          = "Stores";
        $storeType      = "world";
        $stores         = Session::get('stores');
        $globalAverages = $this->getGlobalAveragesForGoods('server', $stores);

        return view('stores.world', compact('stores', 'storeType', 'title', 'globalAverages'));
    }


    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function serverIndex()
    {
        $title          = "Stores";
        $storeType      = "server";
        $stores         = Session::get('stores');
        $globalAverages = $this->getGlobalAveragesForGoods('server', $stores);

        return view('stores.server', compact('stores', 'storeType', 'title', 'globalAverages'));
    }


    /**
     * @param $levelToSearch
     * @param $stores
     *
     * @return array
     */
    private function getGlobalAveragesForGoods($levelToSearch, $stores)
    {
        //$searchUsername = $currentUser->server_username ?? $currentUser->username;
        //todo: to actually limit to a personal/world/server levels we will have to refactor how we get the data
        $globalAverages = [];
        foreach ($stores as $storeData) {
            foreach ($storeData['Averages'] as $goodType => $goodTypeData) {
                foreach ($goodTypeData as $transactionType => $transactionTypeData) {
                    foreach ($transactionTypeData as $good => $goodData) {
                        $globalAverages[$goodType][$transactionType][$good]['price']   = (empty($globalAverages[$goodType][$transactionType][$good]['price']))
                            ? $goodData['Price']
                            : $globalAverages[$goodType][$transactionType][$good]['price'] + $goodData['Price'];
                        $globalAverages[$goodType][$transactionType][$good]['count']   = (empty($globalAverages[$goodType][$transactionType][$good]['count']))
                            ? 1 : $globalAverages[$goodType][$transactionType][$good]['count'] + 1;
                        $globalAverages[$goodType][$transactionType][$good]['average'] = $globalAverages[$goodType][$transactionType][$good]['price'] / $globalAverages[$goodType][$transactionType][$good]['count'];
                    }
                }
            }
        }

        return $globalAverages;
    }


    /**
     * note: this gets all the transactions for the stores and returns it with the ids converted to titles.
     *
     * @return object
     */
    public function getTransactionsUsingTitles()
    {
        $transactions = new Transactions();
        $this->data   = [];
        $transactions->orderby('good_type_id','ASC')->orderby('transaction_type_id','DESC')->orderby('good_id','DESC')->chunk(400, function ($transactions) {
            foreach ($transactions as $transaction) {
                $tradeZone       = TradeZones::find($transaction->trade_zone_id);
                $goodType        = GoodTypes::find($transaction->good_type_id);
                $item            = $this->getGoodFromGoodTypeAndGoodId($goodType, $transaction->good_id);
                $transactionType = $this->getTransactionTypeFromId($transaction->transaction_type_id);
                $transactionType = ($transactionType->title === 'buy') ? 'Orders' : 'Offers';
                $owner           = $transaction->owner;
                $gps             = $tradeZone->gps;
                $price           = $transaction->value;
                $amount          = $transaction->amount;
                $sum             = $price * $amount;
                $goodTitle       = $goodType->title;
                $itemTitle       = $item->title;
                $gridName        = $tradeZone->title;

                if ($tradeZone->count() > 0 && $goodType->count() > 0 && $item->count() > 0) {
                    if (empty($this->data[$gridName])) {
                        $this->data[$gridName]['Info']['Owner'] = $owner;
                        $this->data[$gridName]['Info']['GPS']   = $gps;
                        $this->data[$gridName]['Totals']        = [];
                    }
                    if (empty($this->data[$gridName]['Data'][$goodTitle])) {
                        $this->data[$gridName]['Data'][$goodTitle]['Offers'] = [];
                        $this->data[$gridName]['Data'][$goodTitle]['Orders'] = [];
                    }
                    if (empty($this->data[$gridName]['Totals'][$goodTitle][$transactionType][$itemTitle])) {
                        $this->data[$gridName]['Totals'][$goodTitle][$transactionType][$itemTitle]            = [
                            'Amount'   => 0,
                            'Price'    => 0,
                            'Sum'      => 0,
                            'MinPrice' => 0,
                            'MaxPrice' => 0,
                        ];
                        $this->data[$gridName]['Averages'][$goodTitle][$transactionType][$itemTitle]['Price'] = 0;
                        $this->data[$gridName]['Averages'][$goodTitle][$transactionType][$itemTitle]['Sum'] = 0;
                    }

                    $this->data[$gridName]['Data'][$goodTitle][$transactionType][$itemTitle]['Transactions'][] = [
                        'Amount' => $amount,
                        'Price'  => $price,
                        'Sum'    => $sum
                    ];
                    $this->data[$gridName]['Totals'][$goodTitle][$transactionType][$itemTitle]['Amount']       += $amount;
                    $this->data[$gridName]['Totals'][$goodTitle][$transactionType][$itemTitle]['Price']        += $amount * $price;
                    $this->data[$gridName]['Totals'][$goodTitle][$transactionType][$itemTitle]['Sum']        += $sum;
                    if (($this->data[$gridName]['Totals'][$goodTitle][$transactionType][$itemTitle]['MinPrice'] > $price) || $this->data[$gridName]['Totals'][$goodTitle][$transactionType][$itemTitle]['MinPrice'] === 0) {
                        $this->data[$gridName]['Totals'][$goodTitle][$transactionType][$itemTitle]['MinPrice'] = $price;
                    }
                    if ($this->data[$gridName]['Totals'][$goodTitle][$transactionType][$itemTitle]['MaxPrice'] < $price) {
                        $this->data[$gridName]['Totals'][$goodTitle][$transactionType][$itemTitle]['MaxPrice'] = $price;
                    }
                    if ($this->data[$gridName]['Totals'][$goodTitle][$transactionType][$itemTitle]['Price'] > 0 && $this->data[$gridName]['Totals'][$goodTitle][$transactionType][$itemTitle]['Amount'] > 0) {
                        $this->data[$gridName]['Averages'][$goodTitle][$transactionType][$itemTitle]['Price'] = $this->data[$gridName]['Totals'][$goodTitle][$transactionType][$itemTitle]['Price'] / $this->data[$gridName]['Totals'][$goodTitle][$transactionType][$itemTitle]['Amount'];
                        $this->data[$gridName]['Averages'][$goodTitle][$transactionType][$itemTitle]['Sum'] = $this->data[$gridName]['Totals'][$goodTitle][$transactionType][$itemTitle]['Sum'] / $this->data[$gridName]['Totals'][$goodTitle][$transactionType][$itemTitle]['Amount'];
                    }
                }
            }
        });

        return (object)$this->data;
    }
}
