<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TimeEntry;
use App\Project;
use App\Task;

use App\Scopes\HiddenScope;

class TimerController extends Controller
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
    
    public function start(Request $request) {
 
        $this->stopTimer();

        $timeEntry = new TimeEntry;
 
        $project = Project::withoutGlobalScope(HiddenScope::class)->find($request->input('task'));
        if (!$project) {
            $project = company()->getDefaultProject();
        }
        
        $task = Task::withoutGlobalScope(HiddenScope::class)->find($request->input('task'));

        if (!$task) {
            $task = $project->getDefaultTask();
        }

        $timeEntry->start = NOW();
        $timeEntry->user_id = auth()->user()->id;
        $timeEntry->task_id = $task->id;
        $timeEntry->description = $request->input('description');
        $timeEntry->save();

        return redirect(url()->previous());
    }

    public function stop() {
        $this->stopTimer();
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
