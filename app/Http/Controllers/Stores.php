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
            $group      = $this->seNameToGroup($store->Item);
            $item       = ucfirst($this->seNameToItemTitle($group, $store->Item));
            if(! empty($item)) {
                $type   = ($store->offerOrOrder === 'Order') ? 'Orders' : 'Offers';
                $amount = (int)$store->Qty;
                $price  = (float)$store->pricePerUnit;
                if (empty($data[$gridName])) {
                    $data[$gridName]['Info']['Owner']           = $store->Owner;
                    $data[$gridName]['Info']['GPS']             = $store->GPSString;
                    $data[$gridName]['Totals']                  = [];
                }
                if(empty($data[$gridName]['Data'][$group->title])) {
                    $data[$gridName]['Data'][$group->title]['Offers']  = [];
                    $data[$gridName]['Data'][$group->title]['Orders']  = [];
                }
                if (empty($data[$gridName]['Totals'][$group->title][$type][$item])) {
                    $data[$gridName]['Totals'][$group->title][$type][$item]            = [
                        'Amount'   => 0,
                        'Price'    => 0,
                        'MinPrice' => 0,
                        'MaxPrice' => 0,
                    ];
                    $data[$gridName]['Averages'][$group->title][$type][$item]['Price'] = 0;
                }

                $data[$gridName]['Data'][$group->title][$type][$item]['Transactions'][] = [
                    'Amount' => $amount,
                    'Price'  => $price
                ];
                $data[$gridName]['Totals'][$group->title][$type][$item]['Amount']  += $amount;
                $data[$gridName]['Totals'][$group->title][$type][$item]['Price']   += $amount * $price;
                if (($data[$gridName]['Totals'][$group->title][$type][$item]['MinPrice'] > $price) || $data[$gridName]['Totals'][$group->title][$type][$item]['MinPrice'] === 0) {
                    $data[$gridName]['Totals'][$group->title][$type][$item]['MinPrice'] = $price;
                }
                if ($data[$gridName]['Totals'][$group->title][$type][$item]['MaxPrice'] < $price) {
                    $data[$gridName]['Totals'][$group->title][$type][$item]['MaxPrice'] = $price;
                }
                if ($data[$gridName]['Totals'][$group->title][$type][$item]['Price'] > 0 && $data[$gridName]['Totals'][$group->title][$type][$item]['Amount'] > 0) {
                    $data[$gridName]['Averages'][$group->title][$type][$item]['Price'] = $data[$gridName]['Totals'][$group->title][$type][$item]['Price'] / $data[$gridName]['Totals'][$group->title][$type][$item]['Amount'];
                }
            }
        }

        return (object) $data;
    }
}
