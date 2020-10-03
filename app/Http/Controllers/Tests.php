<?php

namespace App\Http\Controllers;

use App\Http\Traits\FindingGoods;
use App\Models\Stores;

class Tests extends Controller
{
    use FindingGoods;
    public function test1() {
        $pageTitle  = "Testing numbers work";
        //testing cobalt
        $stores = new Stores();
        $storeRows = $stores->where('offerOrOrder','Order')->where('Item', 'MyObjectBuilder_Ore/Cobalt')->orWhere('Item', 'MyObjectBuilder_Ingot/Cobalt')->get();
        $transactions = [
            'orders' => [
                1 => [],
                2 => [],
                3 => [],
                4 => []
            ]
        ];
        foreach($storeRows as $row) {
            $goodType = $this->seNameToGoodType($row->Item);
            $good = $this->seNameAndGoodTypeToGood($goodType, $row->Item);
            if(! empty($goodType) && ! empty($good)) {
                $transType = ($row->offerOrOrder === "Order") ? 'orders' : 'offers';
                if (empty($transactions[$transType][$goodType->id][$good->id])) {
                    $transactions[$transType][$goodType->id][$good->id] = [
                        'title'       => $good->title,
                        'prices'      => [],
                        'qtys'        => [],
                        'sum'         => 0,
                        'totalAmount' => 0,
                        'average'     => 0,
                        'count'       => 0
                    ];
                }
                $transactions[$transType][$goodType->id][$good->id]['prices'][]    = $row->pricePerUnit;
                $transactions[$transType][$goodType->id][$good->id]['qtys'][]      = $row->Qty;
                $transactions[$transType][$goodType->id][$good->id]['sum']         += $row->pricePerUnit * $row->Qty;
                $transactions[$transType][$goodType->id][$good->id]['totalAmount'] += $row->Qty;
                $transactions[$transType][$goodType->id][$good->id]['average']     = ($transactions[$transType][$goodType->id][$good->id]['totalAmount'] > 0)
                    ? $transactions[$transType][$goodType->id][$good->id]['sum'] / $transactions[$transType][$goodType->id][$good->id]['totalAmount']
                    : 0;
                $transactions[$transType][$goodType->id][$good->id]['count']++;
            }
        }
        ($transactions);

        $compacted = compact('pageTitle', 'transactions');

        return view('tests.test1', $compacted);
    }
    public function nebulonSystem() {
        return view('maps.nebulonSystem');
    }

    public function nebulonSystem3D() {
        return view('maps.nebulonSystem3D');
    }

    public function solarSystem3d() {
        return view('tests.solarSystem3d');
    }

    public function solarSystem() {
        return view('tests.solarSystem');
    }
}
