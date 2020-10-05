<?php namespace App\Http\Controllers;

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
    protected $transaction   = 'offer';


    public function ores()
    {
        $goodType        = 'ores';
        $transactionType = $this->transaction;
        $header          = 'Sell '.$goodType.' to the players';

        return view('transactions.type', compact('transactionType', 'goodType', 'header'));
    }


    public function ingots()
    {
        $goodType        = 'ingots';
        $transactionType = $this->transaction;
        $header          = 'Sell '.$goodType.' to the players';

        return view('transactions.type', compact('transactionType', 'goodType', 'header'));
    }


    public function components()
    {
        $goodType        = 'components';
        $transactionType = $this->transaction;
        $header          = 'Sell '.$goodType.' to the players';

        return view('transactions.type', compact('transactionType', 'goodType', 'header'));
    }


    public function tools()
    {
        $goodType        = 'tools';
        $transactionType = $this->transaction;
        $header          = 'Sell '.$goodType.' to the players';

        return view('transactions.type', compact('transactionType', 'goodType', 'header'));
    }
}
