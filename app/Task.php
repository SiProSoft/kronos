<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    public function project() {
        return $this->belongsTo('App\Project');
    }

    public function timeEntries() {
        return $this->hasMany('App\TimeEntry');
    }

    public function users() {
        return $this->hasManyThrough('App\User', 'App\Project');
    }

    public function displaySum() {
        $time = 0;
        
        foreach ($this->timeEntries as $te) {
            $time += $te->getTime();
        } 
        
        $sum = sprintf('%02d:%02d:%02d', ($time/3600),($time/60%60), $time%60);

        return $sum;
    }
}
