<?php

namespace App\Http\Controllers;

use App\Components;
use App\Ingots;
use App\Ores;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class Orders extends Controller
{
    public function __construct() {
        dd($this->auth);
        View::share([ 'currentUser' => $this->auth->user() ]);
    }
    /**
     * @var int
     */
    protected $defaultAmount = 1000000;

    public function ores() {
        $title = 'Buy ores from the players';
        $exportTitle = 'offer_ores.csv';
        $items = Ores::all();
        $defaultMultiplier = 1;
        $defaultAmount = 0;
        return view('orders.ores', compact('title', 'items', 'defaultMultiplier', 'defaultAmount', 'exportTitle'));
    }

    public function ingots() {
        $title = 'Buy ingots from the players';
        $exportTitle = 'offer_ingots.csv';
        $items = Ingots::all();
        $defaultMultiplier = 1;
        $defaultAmount = 0;
        return view('orders.ingots', compact('title', 'items', 'defaultMultiplier', 'defaultAmount', 'exportTitle'));
    }

    public function components() {
        $title = 'Buy components from the players';
        $exportTitle = 'offer_comps.csv';
        $items = Components::all();
        $defaultMultiplier = 1;
        $defaultAmount = 0;
        return view('orders.components', compact('title', 'items', 'defaultMultiplier', 'defaultAmount', 'exportTitle'));
    }
}
