<?php namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\NewsArticles;
use Illuminate\Http\Request;

class AunController extends Controller
{
    /**
     * Display all articles.
     *
     */
    public function index()
    {
       return NewsArticles::where('news_corp', 'AUN')->get();
    }


    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        return response()->json('Denied', 403);
    }


    /**
     * @param int $id
     *
     * @return mixed
     */
    public function show(int $id)
    {
        return NewsArticles::where('news_corp', 'AUN')->find($id);
    }


    /**
     * @param \Illuminate\Http\Request $request
     * @param                          $id
     *
     * @return mixed
     */
    public function update(Request $request, $id)
    {
        $news = NewsArticles::where('news_corp', 'AUN')->find($id);
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
        $news = NewsArticles::where('news_corp', 'AUN')->find($id);

        return $news->delete();
    }
}
