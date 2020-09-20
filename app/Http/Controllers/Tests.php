<?php

namespace App\Http\Controllers;

use App\Http\Traits\FindingGoods;
use App\Stores;

class Tests extends Controller
{
    use FindingGoods;
    public function test1() {
        $pageTitle  = "Ore Tests";
        //ore test:
        $storeTransactions = new Stores();
        $transactions = $storeTransactions->get();
        $orders = [];
        $offers = [];
        foreach($transactions as $transaction) {
            $goodType = $this->seNameToGoodType($transaction->Item);
            $good = $this->seNameAndGoodTypeToGood($goodType, $transaction->Item);
            if(! empty($goodType) && ! empty($good)) {
                if ($transaction->offerOrOrder = "Order") {
                    if (empty($orders[$goodType->id][$good->id])) {
                        $orders[$goodType->id][$good->id] = [
                            'title'     => $good->title,
                            'sumPrice'  => 0,
                            'sumAmount' => 0
                        ];
                    } else {
                        $orders[$goodType->id][$good->id]['sumPrice']  += $good->pricePerUnit;
                        $orders[$goodType->id][$good->id]['sumAmount'] += $good->Qty;
                    }
                } else {
                    if (empty($offers[$goodType->id][$good->id])) {
                        $offers[$goodType->id][$good->id] = [
                            'title'     => $good->title,
                            'sumPrice'  => 0,
                            'sumAmount' => 0
                        ];
                    } else {
                        $offers[$goodType->id][$good->id]['sumPrice']  += $good->pricePerUnit;
                        $offers[$goodType->id][$good->id]['sumAmount'] += $good->Qty;
                    }
                }
            }
        }
        ksort($orders);
        ksort($offers);

        $compacted = compact('pageTitle', 'orders', 'offers');

        return view('tests.test1', $compacted);
    }
}
