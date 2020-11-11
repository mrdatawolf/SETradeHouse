<?php namespace App\Http\Controllers;

class Calculators extends Controller
{
    public function thrust() {
        $layout =(! empty(\Auth::user())) ? 'layouts.app' : 'layouts.guest';

        return view('calculators.thrust',compact('layout'));
    }
}
