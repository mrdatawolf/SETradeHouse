<?php namespace App\Http\Controllers;

use App\Models\Servers;
use App\Models\Mods;
use Illuminate\Http\Request;

class ModsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mods = Mods::latest()->paginate(5);

        return view('mods.index', compact('mods'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $serverIds = Servers::pluck('id');
        return view('mods.create', compact('serverIds'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'server_id' => 'required',
            'message' => 'required',
        ]);

        Mods::create($request->all());

        return redirect()->route('mods.index')
                         ->with('success', 'Mod created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Mods  $mod
     * @return \Illuminate\Http\Response
     */
    public function show(Mods $mod)
    {
        return view('mods.show', compact('mod'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Mods  $mod
     * @return \Illuminate\Http\Response
     */
    public function edit(Mods $mod)
    {
        $serverIds = Servers::pluck('id');
        return view('mods.edit', compact('mod', 'serverIds'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Mods  $mod
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mods $mod)
    {
        $request->validate([
            'server_id' => 'required',
            'message' => 'required',
        ]);

        $mod->update($request->all());

        return redirect()->route('mods.index')
                         ->with('success', 'Mod updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Mods  $mod
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mods $mod)
    {
        $mod->delete();

        return redirect()->route('mods.index')
                         ->with('success', 'Mod deleted successfully');
    }
}
