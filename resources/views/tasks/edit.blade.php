@extends('layouts.app')

@section('content')

    <div class="container">
        <h1 class="h4">Edit task</h1>
        <hr>
        @include('inc.forms.task-form', ['task' => $task])
    </div>

@endsection
