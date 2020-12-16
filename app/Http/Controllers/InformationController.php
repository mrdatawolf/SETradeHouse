<?php namespace App\Http\Controllers;

use App\Models\Servers;
use App\Models\Information;
use Illuminate\Http\Request;

class InformationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $information = Information::latest()->paginate(5);

        return view('information.index', compact('information'))
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
        return view('information.create', compact('serverIds'));
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

        Information::create($request->all());

        return redirect()->route('information.index')
                         ->with('success', 'Information message created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Information  $information
     * @return \Illuminate\Http\Response
     */
    public function show(Information $information)
    {
        return view('information.show', compact('information'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Information  $information
     * @return \Illuminate\Http\Response
     */
    public function edit(Information $information)
    {
        $serverIds = Servers::pluck('id');
        return view('information.edit', compact('information', 'serverIds'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Information  $information
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Information $information)
    {
        $request->validate([
            'server_id' => 'required',
            'message' => 'required',
        ]);

        $information->update($request->all());

        return redirect()->route('information.index')
                         ->with('success', 'Information message updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Information  $information
     * @return \Illuminate\Http\Response
     */
    public function destroy(Information $information)
    {
        $information->delete();

        return redirect()->route('information.index')
                         ->with('success', 'Information message deleted successfully');
    }
}
