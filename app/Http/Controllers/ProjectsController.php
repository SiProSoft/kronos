<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Project;
use App\TimeEntry;

class ProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $projects = auth()->user()->projects;
        return view('projects.index')->with('projects', $projects);
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
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
        ]);

        $project = new Project;
        $project->title = $request->input('title');
        $project->description = $request->input('description');
        $project->user_id = auth()->user()->id;
        $project->save();

        return redirect('/projects');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $userId = auth()->user()->id;

        $runningTimeEntry = TimeEntry::where(['user_id' => $userId , 'end' => null])->first();
        // $timeEntry = TimeEntry::where(['user_id' => $id, 'end' => null])->first();

        // $timeEntries = TimeEntry::where(['user_id' => $userId])->whereNotNull('end')->orderBy('id', 'desc')->get();
        $project = Project::find($id);
        $timeEntries = $project->timeEntries->filter(function($time) {
            return $time->end != null;
        });

        // $timeEntries = $project->timeEntries;
        
        $sum = 0;

        foreach ($timeEntries as $entry) {
            $sum += $entry->getTime();
        }

        $sumTime = sprintf('%02d:%02d:%02d', ($sum/3600),($sum/60%60), $sum%60);

        return view('projects.show')->with([
            'project' => $project, 
            'runningTimeEntry' => $runningTimeEntry, 
            'timeEntries' => $timeEntries,
            'sum' => $sumTime
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function startTimer($id) {
        $userId = auth()->user()->id;

        $runningTimeEntry = TimeEntry::where(['user_id' => $userId , 'end' => null])->first();

        if ($runningTimeEntry) {
            $runningTimeEntry->end = NOW();
            $runningTimeEntry->save();
        }

        $timeEntry = new TimeEntry;
        $timeEntry->start = NOW();
        $timeEntry->task_id = $id > 0 ? $id : null;
        $timeEntry->user_id = $userId;
        $timeEntry->save();
        
        return redirect(url()->previous());
    }

    // public function stopTimer($id) {
    //     $timeEntry = TimeEntry::find($id);

    //     if ($timeEntry) {
    //         $timeEntry->end = NOW();
    //         $timeEntry->save();
    //     }

    //     return redirect(url()->previous());
    // }
}
