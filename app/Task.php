<?php

namespace App;

use App\Scopes\HiddenScope;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{

    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'scrum_status',
        'scrum_sort'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_hidden' => 'boolean',
    ];


    
    /**
     * Scope a query to exclude hidden projects.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeVisible($query)
    {
        return $query->where('is_hidden', false);
    }

    /**
     * Scope a query to only include tasks attached to a specific company.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeForCompany($query)
    {
        return $query->whereHas('project', function($q) {
            $q->where('projects.company_id', company()->id);
        });
    }

    public function scopeForProject($query, $projectId)
    {
        return $query->where('project_id', $projectId);
    }
    

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
        $sum = sprintf('%02d:%02d:%02d', ($time/3600),($time/60%60), $time%60);

        return $sum;
    }


    // ---------------
    public static function boot()
    {
        parent::boot();
        // static::addGlobalScope(new HiddenScope);

        self::deleting(function($model) {
            $timeEntries = TimeEntry::withoutGlobalScopes()->where('task_id', $model->id)->get();

            $timeEntries->each(function($te) {
                $te->delete();
            });
        });
    }
}
