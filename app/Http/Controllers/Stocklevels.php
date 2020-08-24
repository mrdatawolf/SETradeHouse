<?php

namespace App\Http\Controllers;

use App\Components;
use App\Ingots;
use App\Ores;
use App\Tools;

class Stocklevels extends Controller
{
    public function index() {
        $title = "Stock Levels";
        $playerData = new \App\StockLevels();
        $items = $playerData->distinct()->pluck('Item');
        $stockLevels = [];
        foreach($items as $item) {
            $itemArray = explode('/',$item);
            switch($itemArray[0]) {
                case 'MyObjectBuilder_Ingot' :
                    $itemType = 'Ingots';
                    break;
                case 'MyObjectBuilder_Ore' :
                    $itemType = 'Ores';
                    break;
                case 'MyObjectBuilder_PhysicalGunObject':
                case 'MyObjectBuilder_AmmoMagazine':
                $itemType = 'Tools';
                    break;
                default:
                    $itemType = 'Components';
            }
            $title = $this->getItemTitle($itemType, $item);
            if ( ! empty($title)) {
                $stockLevels[$itemType][$title] = number_format($playerData->where('Item', $item)->sum('Qty'));
            }
        }

        return view('stocklevels', compact('stockLevels','title'));
    }


    /**
     * @param $itemGroup
     * @param $item
     *
     * @return string
     */
    private function getItemTitle($itemGroup, $item) {
        switch($itemGroup) {
            case 'Ingots' :
                $name = Ingots::where('se_name', $item)->pluck('title')->first();
                break;
            case 'Ores' :
                $name = Ores::where('se_name', $item)->pluck('title')->first();
                break;
            case 'Tools' :
            $name = Tools::where('se_name', $item)->pluck('title')->first();
            break;
            default:
                $name = Components::where('se_name', $item)->pluck('title')->first();
        }

        return $name ?? '';
    }

}
