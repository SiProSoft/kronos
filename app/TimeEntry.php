<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TimeEntry extends Model
{
    //
    public function task() {
        return $this->belongsTo('App\Task');
    }

    public function project() {
        return $this->belongsTo('App\Project');
    }

    public function getTime() {
        return strtotime($this->end) - strtotime($this->start);
    }

    public function displayTime() {
        $seconds = $this->getTime();
        return showAsTime($seconds);
    }
}
