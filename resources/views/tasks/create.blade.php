@extends('layouts.app')

@section('content')

    <div class="container">
        <h1 class="h4">Create task</h1>
        <hr>
        @include('inc.forms.task-form', ['task' => null])
    </div>
@endsection
