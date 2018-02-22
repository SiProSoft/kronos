<?php

namespace App;

use App\Scopes\HiddenScope;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_hidden' => 'boolean',
    ];

    public function project() {
        return $this->belongsTo('App\Project')->withoutGlobalScopes();
    }

    public function timeEntries() {
        return $this->hasMany('App\TimeEntry');
    }

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function completed() {
        return $this->completed_at != null;
    }

    public function isInProgress() {
        $runningTimeEntry = auth()->user()->getRunningTimeEntry();
        $isRunning = $runningTimeEntry ? $this->id == $runningTimeEntry->task->id : false;
        return $isRunning;
    }

    public function getProgressInPercent() {
        $time = $this->getTotalTimeSpent();

        if ($this->estimate) {
            
            $percent = $time / $this->estimate * 100;
            return $percent > 100 ? 100 : $percent;
        }
        
        return 0;
    }

    public function getProgressInColor() {
        $percent = $this->getProgressInPercent();
        $color = '';

        
        if ($percent == 0) {
            $color = '#cac8c8';
        }

        else if ($percent < 25) {
            $color = '#06D6A0';
        }

        else if ($percent < 50) {
            $color = '#b1ef3a';
        }

        else if ($percent < 75) {
            $color = '#e3e664';
        }

        else {
            $color = '#EF476F';

        }

        return $color;
    }
    
    public function getTotalTimeSpent() {
        $time = 0;
        
        foreach ($this->timeEntries as $te) {
            if ($te->end) {
                $time += $te->getTime();
            }
        } 
        return $time;
    }
    
    public function displaySum() {
        $time = $this->getTotalTimeSpent();
        
        // foreach ($this->timeEntries as $te) {
        //     if ($te->end) {
        //         $time += $te->getTime();
        //     }
        // } 
        
        $sum = sprintf('%02d:%02d:%02d', ($time/3600),($time/60%60), $time%60);

        return $sum;
    }


    // ---------------
    public static function boot()
    {
        parent::boot();
        static::addGlobalScope(new HiddenScope);
        
        self::deleting(function($model) {
            $timeEntries = TimeEntry::withoutGlobalScopes()->where('task_id', $model->id)->get();

            $timeEntries->each(function($te) {
                $te->delete();
            });
        });
    }
}
