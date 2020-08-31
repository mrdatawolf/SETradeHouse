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
    protected $defaultAmount    = 1000000;
    protected $transaction      = 'offer';

    public function ores() {
        $type = 'ores';
        $transaction = $this->transaction;
        $header = 'Sell ores to the players';
        $items = Ores::all();
        $defaultMultiplier = 1;
        $defaultAmount = $this->defaultAmount;
        return view('transactions.type', compact('transaction', 'type', 'header', 'items', 'defaultMultiplier', 'defaultAmount'));
    }

    public function ingots() {
        $type = 'ingots';
        $title = $this->transaction;
        $header = 'Sell ingots to the players';
        $items = Ingots::all();
        $defaultMultiplier = 1;
        $defaultAmount = $this->defaultAmount;
        return view('transactions.type', compact('transaction', 'type', 'header', 'items', 'defaultMultiplier', 'defaultAmount'));
    }

    public function components() {
        $type = 'components';
        $title = $this->transaction;
        $header = 'Sell components to the players';
        $items = Components::all();
        $defaultMultiplier = 1;
        $defaultAmount = $this->defaultAmount;
        return view('transactions.type', compact('transaction', 'type', 'header', 'items', 'defaultMultiplier', 'defaultAmount'));
    }
}
