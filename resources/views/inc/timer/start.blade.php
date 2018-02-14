@php
    $labelText = $labelText ?? "Start";
@endphp

{!! Form::open(['action' => 'TimerController@start', 'method' => 'POST']) !!}
    <div class="form-group">
        {{ Form::submit($labelText, ['class' => 'btn btn-success']) }}
    </div>

    {{ Form::hidden('task', $taskId) }}
{!! Form::close() !!}
