<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_superuser' => 'boolean',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'is_superuser'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function projects() {
        return $this->hasMany('App\Project');
    }

    public function projectsWithoutHiddenScope() {
        return Project::withoutGlobalScopes()->where('user_id', $this->id)->get();
    }

    public function getDefaultProject() {
        return Project::withoutGlobalScopes()->where('is_hidden', true)->first();
    }
    
    public function tasks() {
        return $this->hasMany('App\Task');
    }

    public function getTimeEntries() {
        $userId = $this->id;
        $timeEntries = TimeEntry::where(['user_id' => $userId])->whereNotNull('end')->get();
        return $timeEntries;
    }

    public function getRunningTimeEntry() {
        $userId = $this->id;
        $runningTimeEntry = TimeEntry::where(['user_id' => $userId , 'end' => null])->first();
        return $runningTimeEntry;
    }

    // BOOT functions
    public static function boot()
    {
        parent::boot();

        self::creating(function($model){
            // ... code here
        });

        self::created(function($model){
            $project = new Project;
            $project->title = "No project";
            $project->user_id = $model->id;
            $project->is_hidden = true;
            $project->save();
        });

        self::updating(function($model){
            // ... code here
        });

        self::updated(function($model){
            // ... code here
        });

        self::deleting(function($model){
            // ... code here
        });

        self::deleted(function($model){
            // ... code here
        });
    }
}
