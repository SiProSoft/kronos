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

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function displaySum() {
        $time = 0;
        
        foreach ($this->timeEntries as $te) {
            if ($te->end) {
                $time += $te->getTime();
            }
        } 
        
        $sum = sprintf('%02d:%02d:%02d', ($time/3600),($time/60%60), $time%60);

        return $sum;
    }
}
