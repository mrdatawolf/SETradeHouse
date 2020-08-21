<?php

namespace App\Http\Controllers;

use App\Components;
use App\Ingots;
use App\Ores;

/**
 * Class Offers
 *
 * @package App\Http\Controllers
 */
class Offers extends Controller
{
    /**
     * @var int
     */
    protected $defaultAmount = 1000000;

    public function ores() {
        $title = 'Sell ores to the players';
        $exportTitle = 'offer_ores.csv';
        $items = Ores::all();
        $defaultMultiplier = 1;
        $defaultAmount = $this->defaultAmount;
        return view('offers.ores', compact('title', 'items', 'defaultMultiplier', 'defaultAmount', 'exportTitle'));
    }

    public function ingots() {
        $title = 'Sell ingots to the players';
        $exportTitle = 'offer_ingots.csv';
        $items = Ingots::all();
        $defaultMultiplier = 1;
        $defaultAmount = $this->defaultAmount;
        return view('offers.ingots', compact('title', 'items', 'defaultMultiplier', 'defaultAmount', 'exportTitle'));
    }

    public function components() {
        $title = 'Sell components to the players';
        $exportTitle = 'offer_comps.csv';
        $items = Components::all();
        $defaultMultiplier = 1;
        $defaultAmount = $this->defaultAmount;
        return view('offers.components', compact('title', 'items', 'defaultMultiplier', 'defaultAmount', 'exportTitle'));
    }
}
