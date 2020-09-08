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
        $goodType           = 'ores';
        $transactionType    = $this->transaction;
        $header             = 'Sell ' . $goodType . ' to the players';
        $goods              = Ores::all();
        $defaultMultiplier  = 1;
        $defaultAmount      = $this->defaultAmount;
        return view('transactions.type', compact('transactionType', 'goodType', 'header', 'goods', 'defaultMultiplier', 'defaultAmount'));
    }

    public function ingots() {
        $goodType           = 'ingots';
        $transactionType    = $this->transaction;
        $header             = 'Sell ' . $goodType . ' to the players';
        $goods              = Ingots::all();
        $defaultMultiplier  = 1;
        $defaultAmount      = $this->defaultAmount;
        return view('transactions.type', compact('transactionType', 'goodType', 'header', 'goods', 'defaultMultiplier', 'defaultAmount'));
    }

    public function components() {
        $goodType           = 'components';
        $transactionType    = $this->transaction;
        $header             = 'Sell ' . $goodType . ' to the players';
        $goods              = Components::all();
        $defaultMultiplier  = 1;
        $defaultAmount      = $this->defaultAmount;
        return view('transactions.type', compact('transactionType', 'goodType', 'header', 'goods', 'defaultMultiplier', 'defaultAmount'));
    }


    public function tools() {
        $goodType           = 'tools';
        $transactionType    = $this->transaction;
        $header             = 'Sell ' . $goodType . ' to the players';
        $goods              = Tools::all();
        $defaultMultiplier  = 1;
        $defaultAmount      = $this->defaultAmount;
        return view('transactions.type', compact('transactionType', 'goodType', 'header', 'goods', 'defaultMultiplier', 'defaultAmount'));
    }
}
