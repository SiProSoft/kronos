<?php

namespace App;



use App\Scopes\HiddenScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Company extends Model
{
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_hidden' => 'boolean',
    ];

    public function users() {
        return $this->belongsToMany('App\User');
    }

    public function owner() {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function projects() {
        return $this->hasMany('App\Project');
    }

    public function projectsWithoutHiddenScope() {
        return $this->hasMany('App\Project')->withoutGlobalScope(HiddenScope::class);
    }

    public function getDefaultProject() {
        return Project::withoutGlobalScopes()->where(['company_id' => $this->id, 'is_hidden' => true ])->first();
    }

    public function getTimeEntries() {
        return Project::forCompany()
            ->get()
            ->map(function($p) {
                return $p->tasksWithoutHiddenScope();
            })
            ->collapse()
            ->map(function($t) {
                return $t->timeEntries;
            })
            ->collapse();
    }

    public function scopeForUser($query, $user = null) {
        $user = $user ?? auth()->user();
        $query->whereHas('users', function($q) use ($user) {
            $q->where('users.id', $user->id);
        });
    }


    /**
     * Scope a query to only show hidden companies.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeHidden($query) 
    {
        $query->where('is_hidden', true);
    }



    /**
     * Scope a query to exclude hidden companies.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeVisible($query)
    {
        return $query->where('is_hidden', false);
    }
    


    // public function getProjectsWithoutScopes() {
    //     return Project::withoutGlobalScopes()->where(['company_id' => $this->id])->get();
    // }

    // public function getTasks() {
    //     return 
    // }

    
    // BOOT functions
    public static function boot()
    {
        parent::boot();
        
        // static::addGlobalScope(new HiddenScope);

        // static::addGlobalScope('user', function (Builder $builder) {
        //     $user = auth()->user();

        //     $builder->whereHas('users', function($q) use ($user) {
        //         $q->where('users.id', $user->id);
        //     });
        // });

        self::created(function($model) {
            $project = new Project;
            $project->title = "No project";
            $project->user_id = $model->user_id;
            $project->company_id = $model->id;
            $project->is_hidden = true;
            $project->save();
        });

        self::deleting(function($model){
            $projects = Project::withoutGlobalScopes()->where(['company_id' => $model->id])->get();
            $projects->each(function($p) {
                $p->delete();
            });

            $user = auth()->user();
            $user->company_id = $user->getDefaultCompany()->id;
            $user->save();
        });
    }


}
