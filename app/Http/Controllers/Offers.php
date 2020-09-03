<?php

namespace App\Http\Controllers;

use App\Components;
use App\Ingots;
use App\Ores;
use App\Tools;

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
        $header = 'Sell ' . $type . ' to the players';
        $items = Ores::all();
        $defaultMultiplier = 1;
        $defaultAmount = $this->defaultAmount;
        return view('transactions.type', compact('transaction', 'type', 'header', 'items', 'defaultMultiplier', 'defaultAmount'));
    }

    public function ingots() {
        $type = 'ingots';
        $transaction = $this->transaction;
        $header = 'Sell ' . $type . ' to the players';
        $items = Ingots::all();
        $defaultMultiplier = 1;
        $defaultAmount = $this->defaultAmount;
        return view('transactions.type', compact('transaction', 'type', 'header', 'items', 'defaultMultiplier', 'defaultAmount'));
    }

    public function components() {
        $type = 'components';
        $transaction = $this->transaction;
        $header = 'Sell ' . $type . ' to the players';
        $items = Components::all();
        $defaultMultiplier = 1;
        $defaultAmount = $this->defaultAmount;
        return view('transactions.type', compact('transaction', 'type', 'header', 'items', 'defaultMultiplier', 'defaultAmount'));
    }


    public function tools() {
        $type = 'tools';
        $transaction = $this->transaction;
        $header = 'Sell ' . $type . ' to the players';
        $items = Tools::all();
        $defaultMultiplier = 1;
        $defaultAmount = $this->defaultAmount;
        return view('transactions.type', compact('transaction', 'type', 'header', 'items', 'defaultMultiplier', 'defaultAmount'));
    }
}
