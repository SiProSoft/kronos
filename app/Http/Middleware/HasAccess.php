<?php

namespace App\Http\Middleware;

use App\Company;
use App\Project;
use App\Task;
use App\TimeEntry;

use Closure;

class HasAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $object, $includeHidden = false)
    {
        $id = $request->route($object);

        switch ($object) {
            case 'company':
                $company = $includeHidden ? Company::forUser()->find($id) : Company::forUser()->visible()->find($id);
                $redirect = !$company ? redirect(route('companies.index'))->with('error', "No Access") : null;
                break;
            case 'project':
                $project = Project::forCompany()->visible()->find($id);
                $redirect = !$project ? redirect(route('projects.index'))->with('error', "No Access") : null;
                break;
            case 'task':
                $task = Task::forCompany()->visible()->find($id);
                $redirect = !$task ? redirect(route('tasks.index'))->with('error', "No Access") : null;
                break;
            case 'timeentry':
                $timeentry = TimeEntry::forCompany()->find($id);
                $redirect = !$timeentry ? redirect(route('timeentries.index'))->with('error', "No Access") : null;
                break;
            default:
                // $redirect = $next($request);
                break;
        }

        $redirect = $redirect ?? $next($request);
        return $redirect; // $next($request);
    }

    function checkCompany() {
        
    }
}
