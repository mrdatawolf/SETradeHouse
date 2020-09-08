<?php

namespace App\Http\Controllers;
use App\GoodTypes;
use App\Http\Traits\CheckNames;
use App\TradeZones;
use App\Transactions;
use \Session;

class Stores extends Controller
{
    use CheckNames;

    protected $data;

    public function index() {
        $title = "Stores";
        $stores = Session::get('stores');

        return view('stores.your', compact('stores','title'));
    }


    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function worldIndex() {
        $title = "Stores";
        $stores = Session::get('stores');

        return view('stores.world', compact('stores','title'));
    }


    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function serverIndex() {
        $title = "Stores";
        $stores = Session::get('stores');

        return view('stores.server', compact('stores','title'));
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
