<?php

namespace App\Http\Controllers;

use App\Models\Components;
use App\Models\GoodTypes;
use App\Http\Traits\FindingGoods;
use App\Models\Ingots;
use App\Models\NpcStorageValues;
use App\Models\Ores;
use App\Models\Tools;
use App\Models\UserStorageValues;

class Stocklevels extends Controller
{
    use FindingGoods;
    public function index() {
        $title = "Stock Levels";
        $stockLevels = $this->getStockLevels();

        return view('stocklevels', compact('stockLevels','title'));
    }

    public function getStockLevels() {
        $usersStorage       = new UserStorageValues();
        $npcsStorage        = new NpcStorageValues();
        $summedUserTotals   = $usersStorage->select('server_id','world_id','group_id','item_id', \DB::raw('sum(amount) amount'))->groupBy('server_id','world_id','group_id','item_id')->get();
        $summedNpcTotals    = $npcsStorage->select('server_id','world_id','group_id','item_id', \DB::raw('sum(amount) amount'))->groupBy('server_id','world_id','group_id','item_id')->get();

        $stockLevels = [];
        foreach($summedUserTotals as $row) {
            $group = GoodTypes::find($row->group_id);
            $stockModel = $this->getStockModel($row->group_id);
            $item = $stockModel->find($row->item_id);
            if ( ! empty($item->title)) {
                $stockLevels['user'][$group->title][$item->title] = number_format($row->amount);
            }
        }
        foreach($summedNpcTotals as $row) {
            $group = GoodTypes::find($row->group_id);
            $stockModel = $this->getStockModel($row->group_id);
            $item = $stockModel->find($row->item_id);
            if ( ! empty($item->title)) {
                $stockLevels['npc'][$group->title][$item->title] = number_format($row->amount);
            }
        }

        return $stockLevels;
    }

    private function getStockModel($groupId) {
        switch($groupId) {
            case '2' :
                return new Ingots();
            case '1' :
                return new Ores();
            case '3' :
                return new Components();
            default:
                return new Tools();

        }
    }


}
