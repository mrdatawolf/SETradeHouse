<?php

namespace App\Http\Controllers;

use App\Components;
use App\Ingots;
use App\Ores;
use App\Tools;

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
    protected $defaultAmount    = 100000;
    protected $transaction      = 'order';

    public function ores() {
        $goodType           = 'ores';
        $transactionType    = $this->transaction;
        $header             = 'Buy ' . $goodType . ' from the players';
        $goods              = Ores::all();
        $defaultMultiplier  = .95;
        $defaultAmount      = $this->defaultAmount;
        return view('transactions.type', compact('transactionType', 'goodType', 'header', 'goods', 'defaultMultiplier', 'defaultAmount'));
    }

    public function ingots() {
        $goodType           = 'ingots';
        $transactionType    = $this->transaction;
        $header             = 'Buy ' . $goodType . ' from the players';
        $goods              = Ingots::all();
        $defaultMultiplier  = .95;
        $defaultAmount      = $this->defaultAmount;
        return view('transactions.type', compact('transactionType', 'goodType', 'header', 'goods', 'defaultMultiplier', 'defaultAmount'));
    }

    public function components() {
        $goodType           = 'components';
        $transactionType    = $this->transaction;
        $header             = 'Buy ' . $goodType . ' from the players';
        $goods              = Components::all();
        $defaultMultiplier  = .95;
        $defaultAmount      = $this->defaultAmount;
        return view('transactions.type', compact('transactionType', 'goodType', 'header', 'goods', 'defaultMultiplier', 'defaultAmount'));
    }

    public function tools() {
        $goodType           = 'tools';
        $transactionType    = $this->transaction;
        $header             = 'Buy ' . $goodType . ' from the players';
        $goods              = Tools::all();
        $defaultMultiplier  = .95;
        $defaultAmount  = $this->defaultAmount;
        return view('transactions.type', compact('transactionType', 'goodType', 'header', 'goods', 'defaultMultiplier', 'defaultAmount'));
    }
}
