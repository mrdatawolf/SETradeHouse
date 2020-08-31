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
    protected $defaultAmount    = 1000000;
    protected $transaction      = 'order';

    public function ores() {
        $type               = 'ores';
        $transaction        = $this->transaction;
        $header             = 'Buy ores from the players';
        $items              = Ores::all();
        $defaultMultiplier  = 1;
        $defaultAmount = $this->defaultAmount;
        return view('transactions.type', compact('transaction', 'type', 'header', 'items', 'defaultMultiplier', 'defaultAmount'));
    }

    public function ingots() {
        $type               = 'ingots';
        $transaction        = $this->transaction;
        $header             = 'Buy ingots from the players';
        $items              = Ingots::all();
        $defaultMultiplier  = 1;
        $defaultAmount      = $this->defaultAmount;
        return view('transactions.type', compact('transaction', 'type', 'header', 'items', 'defaultMultiplier', 'defaultAmount'));
    }

    public function components() {
        $type = 'components';
        $transaction = $this->transaction;
        $header = 'Buy components from the players';
        $items = Components::all();
        $defaultMultiplier = 1;
        $defaultAmount = $this->defaultAmount;
        return view('transactions.type', compact('transaction', 'type', 'header', 'items', 'defaultMultiplier', 'defaultAmount'));
    }
}
