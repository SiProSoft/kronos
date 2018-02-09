<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TimeEntry;
use App\Task;

class TimeEntriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $timeEntries = TimeEntry::all();
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
        $projects = auth()->user()->projects->mapWithKeys(function($p) {
            return [$p->id => $p->title];
        });

        // return $projects->toArray();
        $tasks = ($timeEntry->project ? $timeEntry->project->tasks : Task::where(['user_id' => $userId, 'project_id' => null])->get())->mapWithKeys(function($t) {
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
        $timeEntry = TimeEntry::find($id);

        // $timeEntry->start = NOW();
        // $timeEntry->user_id = auth()->user()->id;
        $timeEntry->task_id = $request->input('task');
        $timeEntry->project_id = $request->input('project');
        $timeEntry->description = $request->input('description');
        $timeEntry->save();

        return redirect('/timeentries');
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

        return redirect('/timeentries');
    }
}
