<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TimeEntry extends Model
{
    //
    public function task() {
        return $this->belongsTo('App\Task');
    }

    public function getTime() {
        return strtotime($this->end) - strtotime($this->start);
    }

    public function displayTime() {
        $time = $this->getTime();
        return sprintf('%02d:%02d:%02d', ($time/3600),($time/60%60), $time%60);

    }
}
