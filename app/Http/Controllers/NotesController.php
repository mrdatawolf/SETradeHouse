<?php namespace App\Http\Controllers;

use App\Models\Servers;
use App\Models\Notes;
use Illuminate\Http\Request;

class NotesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notes = Notes::latest()->paginate(5);

        return view('notes.index', compact('notes'))
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
        return view('notes.create', compact('serverIds'));
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

        Notes::create($request->all());

        return redirect()->route('notes.index')
                         ->with('success', 'Note created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Notes  $note
     * @return \Illuminate\Http\Response
     */
    public function show(Notes $note)
    {
        return view('notes.show', compact('note'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Notes  $note
     * @return \Illuminate\Http\Response
     */
    public function edit(Notes $note)
    {
        $serverIds = Servers::pluck('id');
        return view('notes.edit', compact('note', 'serverIds'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Notes  $note
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Notes $note)
    {
        $request->validate([
            'server_id' => 'required',
            'message' => 'required',
        ]);

        $note->update($request->all());

        return redirect()->route('notes.index')
                         ->with('success', 'Note updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Notes  $note
     * @return \Illuminate\Http\Response
     */
    public function destroy(Notes $note)
    {
        $note->delete();

        return redirect()->route('notes.index')
                         ->with('success', 'Note deleted successfully');
    }
}
