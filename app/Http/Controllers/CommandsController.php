<?php namespace App\Http\Controllers;

use App\Models\Servers;
use App\Models\Commands;
use Illuminate\Http\Request;

class CommandsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $commands = Commands::latest()->paginate(5);

        return view('commands.index', compact('commands'))
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
        return view('commands.create', compact('serverIds'));
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

        Commands::create($request->all());

        return redirect()->route('commands.index')
                         ->with('success', 'Commands message created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Commands  $command
     * @return \Illuminate\Http\Response
     */
    public function show(Commands $command)
    {
        return view('commands.show', compact('command'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Commands  $command
     * @return \Illuminate\Http\Response
     */
    public function edit(Commands $command)
    {
        $serverIds = Servers::pluck('id');
        return view('commands.edit', compact('command', 'serverIds'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Commands  $command
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Commands $command)
    {
        $request->validate([
            'server_id' => 'required',
            'message' => 'required',
        ]);

        $command->update($request->all());

        return redirect()->route('commands.index')
                         ->with('success', 'Commands message updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Commands  $command
     * @return \Illuminate\Http\Response
     */
    public function destroy(Commands $command)
    {
        $command->delete();

        return redirect()->route('commands.index')
                         ->with('success', 'Commands deleted successfully');
    }
}
