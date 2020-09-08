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

    public function index() {
        $title      = "Stores";
        $storeType  = "personal";
        $stores     = Session::get('stores');


        return view('stores.personal', compact('stores', 'storeType', 'title'));
    }


    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function worldIndex() {
        $title      = "Stores";
        $storeType  = "world";
        $stores     = Session::get('stores');

        return view('stores.world', compact('stores','storeType', 'title'));
    }


    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function serverIndex() {
        $title          = "Stores";
        $storeType      = "server";
        $stores         = Session::get('stores');
        $globalAverages = $this->getGlobalAveragesForGoods('server',$stores);

        return view('stores.server', compact('stores','storeType', 'title', 'globalAverages'));
    }


    /**
     * @param $levelToSearch
     * @param $stores
     *
     * @return array
     */
    private function getGlobalAveragesForGoods($levelToSearch,$stores) {
        //$searchUsername = $currentUser->server_username ?? $currentUser->username;
        //todo: to actually limit to a personal/world/server levels we will have to refactor how we get the data
        $globalAverages = [];
        foreach($stores as $storeData) {
            foreach($storeData['Averages'] as $goodType => $goodTypeData) {
                foreach($goodTypeData as $transactionType => $transactionTypeData) {
                    foreach($transactionTypeData as $good => $goodData) {
                        $globalAverages[$goodType][$transactionType][$good]['price']    = (empty($globalAverages[$goodType][$transactionType][$good]['price'])) ? $goodData['Price'] : $globalAverages[$goodType][$transactionType][$good]['price']+$goodData['Price'];
                        $globalAverages[$goodType][$transactionType][$good]['count']    = (empty($globalAverages[$goodType][$transactionType][$good]['count'])) ? 1 : $globalAverages[$goodType][$transactionType][$good]['count']+1;
                        $globalAverages[$goodType][$transactionType][$good]['average']  = $globalAverages[$goodType][$transactionType][$good]['price']/$globalAverages[$goodType][$transactionType][$good]['count'];
                    }
                }
            }
        }

        return $globalAverages;
    }


    /**
     * note: this gets all the transactions for the stores and returns it with the ids converted to titles.
     * @return object
     */
    public function getTransactionsUsingTitles() {
        $transactions = new Transactions();
        $this->data = [];
        $transactions->chunk(400, function ($transactions) {
            foreach($transactions as $transaction) {
                $tradeZone =  TradeZones::find($transaction->trade_zone_id);
                $goodType = GoodTypes::find($transaction->good_type_id);
                $item =$this->getGoodFromGoodTypeAndGoodId($goodType, $transaction->good_id);
                $transactionType = $this->getTransactionTypeFromId($transaction->transaction_type_id);
                $gridName = $tradeZone->title;
                $owner = $transaction->owner;
                $gps = $tradeZone->gps;
                $price = $transaction->value;
                $amount = $transaction->amount;
                $transactionType = ($transactionType->title === 'buy') ? 'Orders' : 'Offers';

                if($tradeZone->count() > 0 && $goodType->count() > 0 && $item->count() > 0) {
                    if (empty($this->data[$gridName])) {
                        $this->data[$gridName]['Info']['Owner'] = $owner;
                        $this->data[$gridName]['Info']['GPS']   = $gps;
                        $this->data[$gridName]['Totals']        = [];
                    }
                    if (empty($this->data[$gridName]['Data'][$goodType->title])) {
                        $this->data[$gridName]['Data'][$goodType->title]['Offers'] = [];
                        $this->data[$gridName]['Data'][$goodType->title]['Orders'] = [];
                    }
                    if (empty($this->data[$gridName]['Totals'][$goodType->title][$transactionType][$item->title])) {
                        $this->data[$gridName]['Totals'][$goodType->title][$transactionType][$item->title]            = [
                            'Amount'   => 0,
                            'Price'    => 0,
                            'MinPrice' => 0,
                            'MaxPrice' => 0,
                        ];
                        $this->data[$gridName]['Averages'][$goodType->title][$transactionType][$item->title]['Price'] = 0;
                    }

                    $this->data[$gridName]['Data'][$goodType->title][$transactionType][$item->title]['Transactions'][] = [
                        'Amount' => $amount,
                        'Price'  => $price
                    ];
                    $this->data[$gridName]['Totals'][$goodType->title][$transactionType][$item->title]['Amount']       += $amount;
                    $this->data[$gridName]['Totals'][$goodType->title][$transactionType][$item->title]['Price']        += $amount * $price;
                    if (($this->data[$gridName]['Totals'][$goodType->title][$transactionType][$item->title]['MinPrice'] > $price) || $this->data[$gridName]['Totals'][$goodType->title][$transactionType][$item->title]['MinPrice'] === 0) {
                        $this->data[$gridName]['Totals'][$goodType->title][$transactionType][$item->title]['MinPrice'] = $price;
                    }
                    if ($this->data[$gridName]['Totals'][$goodType->title][$transactionType][$item->title]['MaxPrice'] < $price) {
                        $this->data[$gridName]['Totals'][$goodType->title][$transactionType][$item->title]['MaxPrice'] = $price;
                    }
                    if ($this->data[$gridName]['Totals'][$goodType->title][$transactionType][$item->title]['Price'] > 0 && $this->data[$gridName]['Totals'][$goodType->title][$transactionType][$item->title]['Amount'] > 0) {
                        $this->data[$gridName]['Averages'][$goodType->title][$transactionType][$item->title]['Price'] = $this->data[$gridName]['Totals'][$goodType->title][$transactionType][$item->title]['Price'] / $this->data[$gridName]['Totals'][$goodType->title][$transactionType][$item->title]['Amount'];
                    }
                }
            }
        });

        return (object) $this->data;
    }
}
