<?php namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\NewsArticles;
use Illuminate\Http\Request;

class TldrController extends Controller
{
    /**
     * Display all articles.
     *
     */
    public function index()
    {
       return NewsArticles::where('news_corp', 'TLDR')->get();
    }


    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function store(Request $request)
    {
        if(auth()->id() === 16) {
            return NewsArticles::create($request->all());
        } else {
            return response()->json('Denied', 403);
        }
    }


    /**
     * @param int $id
     *
     * @return mixed
     */
    public function show(int $id)
    {
        return NewsArticles::where('news_corp', 'TLDR')->find($id);
    }


    /**
     * @param \Illuminate\Http\Request $request
     * @param                          $id
     *
     * @return mixed
     */
    public function update(Request $request, $id)
    {
        if(auth()->id() === 16) {
            $news = NewsArticles::where('news_corp', 'TLDR')->find($id);
            $news->update($request->all());

            return $news;
        } else {
            return response()->json('Denied', 403);
        }
    }


    /**
     * @param $id
     *
     * @return mixed
     */
    public function destroy($id)
    {
        if(auth()->id() === 16) {
            $news = NewsArticles::where('news_corp', 'TLDR')->find($id);

            return $news->delete();
        } else {
            return response()->json('Denied', 403);
        }
    }
}
