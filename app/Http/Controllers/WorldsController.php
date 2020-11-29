<?php namespace App\Http\Controllers;

use App\Models\Worlds;
use Illuminate\Http\Request;

class WorldsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('worlds.common');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('worlds.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return view('worlds.store');
    }


    /**
     * Display the specified resource.
     *
     * @param                    $worldId
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show($worldId)
    {

        return view('worlds.common', compact('worldId'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Worlds  $worlds
     * @return \Illuminate\Http\Response
     */
    public function edit(Worlds $worlds)
    {
        return view('worlds.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Worlds  $worlds
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Worlds $worlds)
    {
        return view('worlds.update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Worlds  $worlds
     * @return \Illuminate\Http\Response
     */
    public function destroy(Worlds $worlds)
    {
        return view('worlds.destroy');
    }
}
