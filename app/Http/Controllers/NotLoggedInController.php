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
        $layout =(! empty(\Auth::user())) ? 'layouts.app' : 'layouts.guest';
        //todo = from the url apply a default serverID
        $serverId = 1;
        $title           = "Stores";
        $storeType       = "server";
        $storeController = new Stores();
        $stores          = $storeController->getTransactionsUsingTitles($serverId);

        return view('stores.notloggedin', compact('stores', 'storeType', 'title', 'layout'));
    }
}
