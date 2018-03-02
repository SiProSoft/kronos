@php
$action = $task ? ['TasksController@update', $task->id] : 'TasksController@store';
@endphp

{!! Form::open(['action' => $action, 'method' => 'POST']) !!}
<div class="form-group">
    {{ Form::label('title', 'Title' ) }}
    {{ Form::text('title', $task ? $task->title : null, ['class' => 'form-control'] ) }}
</div>        
<div class="form-group">
    {{ Form::label('description', 'Description' ) }}
    {{ Form::text('description', $task ? $task->description : null, ['class' => 'form-control'] ) }}
</div>

<div class="form-group">
    {{ Form::label('estimate', 'Estimate (Default is hours)') }}
    {{--  <p class="small">Append "h", "m" and "s" to define Hours, Minutes and Seconds</p>  --}}
    {{ Form::text('estimate', $task ? ($task->estimate / 60 / 60) : null, ['class' => 'form-control'] ) }}
</div>

<div class="form-group">
    {{ Form::label('project', 'Project' ) }}
    {{ Form::select('project', $projects /*company()->getProjectsWithoutScopes()->pluck('title', 'id')*/, $task && $task->project ? $task->project->id : null, ['class' => 'form-control']) }}
</div>

<div class="form-group">
    {{ Form::submit('Submit', ['class' => 'btn btn-primary']) }}
</div>

@if ($task)
{{ Form::hidden('_method', 'PUT') }}
@endif

{!! Form::close() !!}  