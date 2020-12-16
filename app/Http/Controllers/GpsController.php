<?php namespace App\Http\Controllers;

use App\Models\Servers;
use App\Models\Gps;
use Illuminate\Http\Request;

class GpsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $gps = Gps::latest()->paginate(5);

        return view('gps.index', compact('gps'))
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
        return view('gps.create', compact('serverIds'));
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

        Gps::create($request->all());

        return redirect()->route('gps.index')
                         ->with('success', 'Gps message created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Gps $gp
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Gps $gp)
    {
        return view('gps.show', compact('gp'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Gps $gp
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Gps $gp)
    {
        $serverIds = Servers::pluck('id');
        return view('gps.edit', compact('gp', 'serverIds'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param \App\Models\Gps          $gp
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Gps $gp)
    {
        $request->validate([
            'server_id' => 'required',
            'message' => 'required',
        ]);
        $gp->update($request->all());

        return redirect()->route('gps.index')
                         ->with('success', 'Gps message updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Gps $gp
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Gps $gp)
    {
        $gp->delete();

        return redirect()->route('gps.index')
                         ->with('success', 'Gps message deleted successfully');
    }
}
