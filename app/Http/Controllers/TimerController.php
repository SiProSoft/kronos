<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TimeEntry;

class TimerController extends Controller
{
    public function start(Request $request) {
        $timeEntry = new TimeEntry;

 
        $project = $request->input('project');
        
        $timeEntry->task_id = $request->input('task');
        $timeEntry->title = $request->input('title');
        $timeEntry->description = $request->input('description');
    }

    public function stop($id) {
        $timeEntry = TimeEntry::find($id);

        if ($timeEntry) {
            $timeEntry->end = NOW();
            $timeEntry->save();
        }

        return redirect(url()->previous());
    }

    public function update() {

    }
}
