<?php namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\NewsArticles;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * Display all articles.
     *
     */
    public function index()
    {
       return NewsArticles::all();
    }

    /**
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): \Illuminate\Http\Response
    {
        return NewsArticles::create($request->all());
    }


    /**
     * @param int $id
     *
     * @return mixed
     */
    public function show(int $id)
    {
        return NewsArticles::find($id);
    }


    /**
     * @param \Illuminate\Http\Request $request
     * @param                          $id
     *
     * @return mixed
     */
    public function update(Request $request, $id)
    {
        $news = NewsArticles::find($id);
        $news->update($request->all());

        return $news;
    }


    /**
     * @param $id
     *
     * @return mixed
     */
    public function destroy($id)
    {
        $news = NewsArticles::find($id);

        return $news->delete();
    }
}
