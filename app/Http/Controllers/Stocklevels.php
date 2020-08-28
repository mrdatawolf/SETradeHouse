<?php

namespace App\Http\Controllers;

use App\Http\Traits\CheckNames;
use App\UserItems;

class Stocklevels extends Controller
{
    use CheckNames;
    public function index() {
        $title = "Stock Levels";
        $stockLevels = \Session::get('stockLevels');

        return view('stocklevels', compact('stockLevels','title'));
    }

    public function getStockLevels() {
        $stockData = new UserItems();
        $items = $stockData->distinct()->pluck('Item');
        $stockLevels = [];
        foreach($items as $item) {
            $itemType = $this->seNameToGroup($item);

            $title = $this->seNameToTitle($itemType, $item);
            if ( ! empty($title)) {
                $stockLevels[$itemType][$title] = number_format($stockData->where('Item', $item)->sum('Qty'));
            }
        }

        return $stockLevels;
    }
}
