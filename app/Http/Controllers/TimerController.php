<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TimeEntry;

class TimerController extends Controller
{
    public function start(Request $request) {
 
        $this->stopTimer();

        $timeEntry = new TimeEntry;
 
        // $project = $request->input('project');
        
        $timeEntry->start = NOW();
        $timeEntry->user_id = auth()->user()->id;
        $timeEntry->task_id = $request->input('task');
        $timeEntry->project_id = $request->input('project');
        $timeEntry->description = $request->input('description');
        $timeEntry->save();

        return redirect(url()->previous());
    }

    public function stop($id) {
        $timeEntry = TimeEntry::find($id);

        if ($timeEntry) {
            $timeEntry->end = NOW();
            $timeEntry->save();
        }

        return redirect(url()->previous());
    }

    public function stopTimer() {

        $runningTimeEntry = $this->getRunningTimer();
        if ($runningTimeEntry) {
            $runningTimeEntry->end = NOW();
            $runningTimeEntry->save();
        }
    }

    public function getRunningTimer() {
        $userId = auth()->user()->id;
        $runningTimeEntry = TimeEntry::where(['user_id' => $userId , 'end' => null])->first();
        return $runningTimeEntry;
    }

    public function update() {

    }
}
