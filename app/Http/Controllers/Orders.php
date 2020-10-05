<?php namespace App\Http\Controllers;

/**
 * Class Orders
 *
 * @package App\Http\Controllers
 */
class Orders extends Controller
{
    protected $transaction = 'order';


    public function ores()
    {
        $goodType        = 'ores';
        $transactionType = $this->transaction;
        $header          = 'Buy '.$goodType.' from the players';

        return view('transactions.type', compact('transactionType', 'goodType', 'header'));
    }


    public function ingots()
    {
        $goodType        = 'ingots';
        $transactionType = $this->transaction;
        $header          = 'Buy '.$goodType.' from the players';

        return view('transactions.type', compact('transactionType', 'goodType', 'header'));
    }


    public function components()
    {
        $goodType        = 'components';
        $transactionType = $this->transaction;
        $header          = 'Buy '.$goodType.' from the players';

        return view('transactions.type', compact('transactionType', 'goodType', 'header'));
    }


    public function tools()
    {
        $goodType        = 'tools';
        $transactionType = $this->transaction;
        $header          = 'Buy '.$goodType.' from the players';

        return view('transactions.type', compact('transactionType', 'goodType', 'header'));
    }
}
