<?php namespace App\Http\Controllers;

class NewsStories extends Controller
{
    public function aun() {
        $layout =(! empty(\Auth::user())) ? 'layouts.app' : 'layouts.guest';

        return view('news.aun',compact('layout'));
    }

    public function tldr() {
        $layout =(! empty(\Auth::user())) ? 'layouts.app' : 'layouts.guest';

        return view('news.tldr',compact('layout'));
    }
}
