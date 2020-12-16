<?php namespace App\Http\Controllers;

use App\Models\Servers;
use App\Models\Rules;
use Illuminate\Http\Request;

class RulesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rules = Rules::latest()->paginate(5);

        return view('rules.index', compact('rules'))
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
        return view('rules.create', compact('serverIds'));
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

        Rules::create($request->all());

        return redirect()->route('rules.index')
                         ->with('success', 'Rule created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Rules  $rule
     * @return \Illuminate\Http\Response
     */
    public function show(Rules $rule)
    {
        return view('rules.show', compact('rule'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Rules  $rule
     * @return \Illuminate\Http\Response
     */
    public function edit(Rules $rule)
    {
        $serverIds = Servers::pluck('id');
        return view('rules.edit', compact('rule', 'serverIds'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Rules  $rule
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Rules $rule)
    {
        $request->validate([
            'server_id' => 'required',
            'message' => 'required',
        ]);

        $rule->update($request->all());

        return redirect()->route('rules.index')
                         ->with('success', 'Rule updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rules  $rule
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rules $rule)
    {
        $rule->delete();

        return redirect()->route('rules.index')
                         ->with('success', 'Rule deleted successfully');
    }
}
