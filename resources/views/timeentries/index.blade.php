@extends('layouts.app')

@section('content')
<div class="container">

        <h4>Time Entries</h4>
        <br>
        {{--  <div><a href="/timeentries/create">Create a task</a></div>  --}}
        @if (count($timeEntries))
            @foreach ($timeEntries as $timeEntry)
            <div class="panel panel-default">
                <div class="panel-body">

                    {{--  Edit/Delete buttons  --}}
                    <div class="pull-right option-menu">

                        <div class="more-group">

                            <a href="#" class="more-group--button ic-more">
                                <img src="{{ asset('img/icon/ic-more.svg') }}" alt="More icon">
                            </a>

                            <div class="more-group--list">

                                <div class="">
                                    <a href="/timeentries/{{$timeEntry->id}}/edit" class="btn btn-sm btn-default">
                                        Edit
                                    </a>
                                </div>
                                
                                <div class="">
                                    {!! Form::open(['action' => ['TimeEntriesController@destroy', $timeEntry->id], 'method' => 'POST']) !!}
                                        {{Form::hidden('_method', 'DELETE')}}
                                        {{Form::submit('Delete', ['class' => 'btn btn-sm btn-danger'])}}
                                    {!! Form::close() !!}
                                </div>
                            </div>
                            
                        </div>
                        
                    </div>
                          
                    <div>
                        {{ $timeEntry->displayTime() }} - {{ $timeEntry->getProject()->title }} - {{ $timeEntry->task->title }}
                    </div>
                    {{--  <div>{{$timeEntry->start}}</div>  --}}
                    <div>{{$timeEntry->description}}</div>
                </div>
                
            </div>
            @endforeach
        @else
            <div>No time entries</div>
        @endif
    
    
</div>
@endsection
