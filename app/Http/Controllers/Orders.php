<?php

namespace App\Http\Controllers;

use App\Components;
use App\Ingots;
use App\Ores;

/**
 * Class Orders
 *
 * @package App\Http\Controllers
 */
class Orders extends Controller
{
    /**
     * @var int
     */
    protected $defaultAmount = 1000000;

    public function ores() {
        $title = 'Buy ores from the players';
        $exportTitle = 'offer_ores.csv';
        $items = Ores::all();
        $defaultMultiplier = 1;
        $defaultAmount = $this->defaultAmount;
        return view('orders.ores', compact('title', 'items', 'defaultMultiplier', 'defaultAmount', 'exportTitle'));
    }

    public function ingots() {
        $title = 'Buy ingots from the players';
        $exportTitle = 'offer_ingots.csv';
        $items = Ingots::all();
        $defaultMultiplier = 1;
        $defaultAmount = $this->defaultAmount;
        return view('orders.ingots', compact('title', 'items', 'defaultMultiplier', 'defaultAmount', 'exportTitle'));
    }

    public function components() {
        $title = 'Buy components from the players';
        $exportTitle = 'offer_comps.csv';
        $items = Components::all();
        $defaultMultiplier = 1;
        $defaultAmount = $this->defaultAmount;
        return view('orders.components', compact('title', 'items', 'defaultMultiplier', 'defaultAmount', 'exportTitle'));
    }
}
