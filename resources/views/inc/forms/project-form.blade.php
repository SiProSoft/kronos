@php
    $action = $project ? ['ProjectsController@update', $project->id] : 'ProjectsController@store';
@endphp

{!! Form::open(['action' => $action, 'method' => 'POST']) !!}
    <div class="form-group">
        {{ Form::label('title', 'Project title') }}
        {{ Form::text('title', $project ? $project->title : null, ['class' => 'form-control', 'placeholder' => 'Project title']) }}
    </div>
    <div class="form-group">
        {{ Form::label('description', 'Description') }}
        {{ Form::text('description', $project ? $project->description : null, ['class' => 'form-control', 'placeholder' => 'Description']) }}
    </div>

    <div class="form-group">
        {{ Form::submit('Submit', ['class' => 'btn btn-primary']) }}
    </div>

    @if ($project)
    {{ Form::hidden('_method', 'PUT') }}
    @endif
    
{!! Form::close() !!}