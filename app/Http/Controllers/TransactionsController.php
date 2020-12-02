<?php namespace App\Http\Controllers;

class TransactionsController extends Controller
{
    public function currentTransactions() {
        return view('current-transactions');
    }
}
