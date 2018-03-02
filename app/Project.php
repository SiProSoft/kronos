<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

use App\Scopes\HiddenScope;

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
    
    public function user() {
        return $this->belongsTo('App\User');
    }

    public function company() {
        return $this->belongsTo('App\Company')->withoutGlobalScope(HiddenScope::class);
    }

    public function tasks() {
        return $this->hasMany('App\Task'); 
    }
    
    public function tasksWithoutHiddenScope() {
        return $this->hasMany('App\Task', 'project_id')->withoutGlobalScope(HiddenScope::class); 
    }
    
    public function timeEntries() {
        $tasks = Task::withoutGlobalScopes()->where('project_id', $this->id)->get();

        $result = $tasks->map(function($t) {
            return $t->timeEntries;
        });

        return $result->collapse();
    }

    public function getDefaultTask() {
        return Task::withoutGlobalScopes()->where(['project_id' => $this->id, 'is_hidden' => true])->first();
    }

    public function scopeForCompany($query, $company = null) {
        $company = $company ?? company();
        return $query->where('company_id', $company->id);
    }

    // public function scopeForCurrentCompany($query) {
    //     return $query->forCompany(company());
    // }

    
    // public function getTasksWithoutGlobalScopes() {
    //     return Task::withoutGlobalScopes()->where('project_id', $this->id)->get();
    // }


    public static function boot()
    {
        parent::boot();
        // static::addGlobalScope(new HiddenScope);

        // static::addGlobalScope('company', function (Builder $builder) {
        //     $builder->where('company_id', '=', auth()->user()->company->id);
        // });


        
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
