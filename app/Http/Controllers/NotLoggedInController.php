<?php

namespace App\Http\Controllers;

class NotLoggedInController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $title           = "Stores";
        $storeType       = "server";
        $storeController = new Stores();
        $stores          = $storeController->getTransactionsUsingTitles();

        return view('stores.notloggedin', compact('stores', 'storeType', 'title'));
    }
}
