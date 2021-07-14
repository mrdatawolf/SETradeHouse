<?php namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
        return response()->json('Denied', 403);
    }


    /**
     * @param $id
     *
     * @return mixed
     */
    public function destroy($id)
    {
        return response()->json('Denied', 403);
    }
}
