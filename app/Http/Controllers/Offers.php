<?php

namespace App\Http\Controllers;

use App\Components;
use App\Ingots;
use App\Ores;
use Illuminate\Support\Facades\Auth;

/**
 * Class Offers
 * @property integer $id
 * @property string $title
 * @property float $base_processing_time_per_ore
 * @property float $base_conversion_efficiency
 * @property float $keen_crap_fix
 * @property float $module_efficiency_modifier
 * @property float $ore_per_ingot
 * @property string $se_name
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
