@php
    $labelText = $labelText ?? "Start";
@endphp

{!! Form::open(['action' => 'TimerController@start', 'method' => 'POST']) !!}
    {{ Form::submit($labelText, ['class' => 'btn btn-success']) }}
    {{ Form::hidden('task', $taskId) }}
{!! Form::close() !!}
