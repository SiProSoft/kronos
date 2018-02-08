<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{

    public function timeEntries() {
        return $this->hasManyThrough('App\TimeEntry', 'App\Task');
    }
    public function tasks() {
        return $this->hasMany('App\Task'); 
    }

    public function user() {
        return $this->belongsTo('App\User');
    }
}
