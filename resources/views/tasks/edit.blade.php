@extends('layouts.app')

@section('content')

    <div class="container">
        @include('inc.forms.task-form', ['task' => $task])
    </div>

@endsection
