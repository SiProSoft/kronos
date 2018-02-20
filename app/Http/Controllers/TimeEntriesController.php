<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TimeEntry;
use App\Task;

class TimeEntriesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();

        $timeEntries = $user->getTimeEntries()->sortByDesc('start');

        return view('timeentries.index')->with('timeEntries', $timeEntries);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $userId = auth()->user()->id;
        
        $timeEntry = TimeEntry::find($id);
        $projects = auth()->user()->projectsWithoutHiddenScope()->mapWithKeys(function($p) {
            return [$p->id => $p->title];
        });

        // return $projects->toArray();
        $tasks = $timeEntry->getProject()->getTasksWithoutGlobalScopes()->mapWithKeys(function($t) {
            return [$t->id => $t->title];
        });
        
        return view("timeentries.edit")->with(
            ['timeEntry' => $timeEntry,
            'projects' => $projects,
            'tasks' => $tasks]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'start' => 'required|date',
            'end' => 'required|date|after:start'
        ]);

        $timeEntry = TimeEntry::find($id);

        $timeEntry->start = $request->input('start');
        $timeEntry->end = $request->input('end');
        $timeEntry->task_id = $request->input('task');
        $timeEntry->description = $request->input('description');
        $timeEntry->save();

        return redirect(route('timeentries.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $timeEntry = TimeEntry::find($id);
        $timeEntry->delete();

        return redirect(route('timeentries.index'));
    }
}
