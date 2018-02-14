<?php

namespace App;

use App\Scopes\HiddenScope;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_hidden' => 'boolean',
    ];


    public function timeEntries() {
        $tasks = Task::withoutGlobalScopes()->where('project_id', $this->id)->get();

        $result = $tasks->map(function($t) {
            return $t->timeEntries;
        });

        return $result->collapse();
    }
    
    public function tasks() {
        return $this->hasMany('App\Task'); 
    }

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function getDefaultTask() {
        return Task::withoutGlobalScopes()->where(['project_id' => $this->id, 'is_hidden' => true])->first();
    }


    public static function boot()
    {
        parent::boot();
        static::addGlobalScope(new HiddenScope);

        self::creating(function($model){
            // ... code here
        });

        self::created(function($model){
            $task = new Task;
            $task->title = "No task";
            $task->project_id = $model->id;
            $task->user_id = $model->user_id;
            $task->is_hidden = true;
            $task->save();
        });

        self::updating(function($model){
            // ... code here
        });

        self::updated(function($model){
            // ... code here
        });

        self::deleting(function($model){
            $tasks = Task::withoutGlobalScopes()->where(['project_id' => $model->id])->get();
            $tasks->each(function($t) {
                $t->delete();
            });
            
        });

        self::deleted(function($model){
            // ... code here
        });
    }

    
}
