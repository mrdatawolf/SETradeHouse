<?php

namespace App\Http\Controllers;
use App\Http\Traits\CheckNames;
use \App\Stores as StoreModel;
use \Session;

class Stores extends Controller
{
    use CheckNames;

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
     * @return object
     */
    public function getStores() {
        $storeData = new StoreModel();
        $data = [];
        foreach($storeData->all() as $store)
        {
            $gridName   = $store->gridName;
            $group      = ucfirst($this->seNameToGroup($store->Item));
            $item       = ucfirst($this->seNameToTitle($group, $store->Item));
            if(! empty($item)) {
                $type   = ($store->offerOrOrder === 'Order') ? 'Orders' : 'Offers';
                $amount = (int)$store->Qty;
                $price  = (float)$store->pricePerUnit;
                if (empty($data[$gridName])) {
                    $data[$gridName]['Info']['Owner']           = $store->Owner;
                    $data[$gridName]['Info']['GPS']             = $store->GPSString;
                    $data[$gridName]['Totals']                  = [];
                }
                if(empty($data[$gridName]['Data'][$group])) {
                    $data[$gridName]['Data'][$group]['Offers']  = [];
                    $data[$gridName]['Data'][$group]['Orders']  = [];
                }
                if (empty($data[$gridName]['Totals'][$group][$type][$item])) {
                    $data[$gridName]['Totals'][$group][$type][$item]            = [
                        'Amount'   => 0,
                        'Price'    => 0,
                        'MinPrice' => 0,
                        'MaxPrice' => 0,
                    ];
                    $data[$gridName]['Averages'][$group][$type][$item]['Price'] = 0;
                }

                $data[$gridName]['Data'][$group][$type][$item]['Transactions'][] = [
                    'Amount' => $amount,
                    'Price'  => $price
                ];
                $data[$gridName]['Totals'][$group][$type][$item]['Amount']  += $amount;
                $data[$gridName]['Totals'][$group][$type][$item]['Price']   += $amount * $price;
                if (($data[$gridName]['Totals'][$group][$type][$item]['MinPrice'] > $price) || $data[$gridName]['Totals'][$group][$type][$item]['MinPrice'] === 0) {
                    $data[$gridName]['Totals'][$group][$type][$item]['MinPrice'] = $price;
                }
                if ($data[$gridName]['Totals'][$group][$type][$item]['MaxPrice'] < $price) {
                    $data[$gridName]['Totals'][$group][$type][$item]['MaxPrice'] = $price;
                }
                if ($data[$gridName]['Totals'][$group][$type][$item]['Price'] > 0 && $data[$gridName]['Totals'][$group][$type][$item]['Amount'] > 0) {
                    $data[$gridName]['Averages'][$group][$type][$item]['Price'] = $data[$gridName]['Totals'][$group][$type][$item]['Price'] / $data[$gridName]['Totals'][$group][$type][$item]['Amount'];
                }
            }
        }

        return (object) $data;
    }
}
