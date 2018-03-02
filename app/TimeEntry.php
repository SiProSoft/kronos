<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TimeEntry extends Model
{
    //
    public function task() {
        return $this->belongsTo('App\Task')->withoutGlobalScopes();
    }

    public function scopeForCompany($query) {
        return $query->whereHas('task', function($q1) {
            // dd($this);
            $q1->whereHas('project', function($q2) {
                $q2->where('projects.company_id', company()->id);
                
            });
        });
    }

    public function getProject() {
        $task = $this->task;
        $project = $task ? $task->project : null;
        
        return $project;
    }

    public function getTime() {
        return strtotime($this->end) - strtotime($this->start);
    }

    public function displayTime() {
        $seconds = $this->getTime();
        return showAsTime($seconds);
    }

}
