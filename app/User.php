<?php

namespace App;

use App\Scopes\HiddenScope;
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

    public function company() {
        return $this->belongsTo('App\Company')->withoutGlobalScope(HiddenScope::class);
    }

    public function companies() {
        return $this->belongsToMany('App\Company');
    }

    public function projects() {
        return $this->hasMany('App\Project');
    }

    public function getTasks() {
        return $this->company->tasks;
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
    
    // public function projectsWithoutHiddenScope() {
    //     return Project::withoutGlobalScopes()->where('user_id', $this->id)->get();
    // }

    public function getDefaultCompany() {
        return Company::withoutGlobalScopes()->where(['user_id' => $this->id, 'is_hidden' => true])->first();
    }






    // public function getTasks() {
    //     $tasks = $this->withoutGlobalScope(HiddenScope::class)->projects->map(function($p) {
    //         return $p->tasks;
    //     })->collapse();

    //     return $tasks;
    // }

    // public function getTimeEntries() {
    //     $tasks = $this->getTasks();
    //     $timeEntries = $tasks->map(function($t) {
    //         return $t->timeEntries;
    //     })->collapse();

    //     return $timeEntries;
    // }




    // BOOT functions
    public static function boot()
    {
        parent::boot();

        self::created(function($model) {
            $company = new Company;
            $company->title = "Personal";
            $company->user_id = $model->id;
            $company->is_hidden = true;
            $company->save();

            $company->users()->attach($model);
            
            $model->company_id = $company->id;
            $model->save();
        });

        self::deleting(function($model) {
            // ... code here
        });
    }
}
