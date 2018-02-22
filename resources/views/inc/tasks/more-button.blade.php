<div class="more-group">

        <a href="#" class="more-group--button ic-more">
            <img src="{{ asset('img/icon/ic-more.svg') }}" alt="More icon">
        </a>

        <div class="more-group--list">

            
            {{--  Start Timer Button  --}}
            <div class="">
                @if (!$task->isInProgress())
                    @include('inc.timer.start', ['taskId' => $task->id])
                @else
                    @include('inc.timer.stop')
                @endif 
            </div>
            
            {{--  Complete Task Button  --}}
            <div class="">
                @if ($task->completed)
                    <a href="{{route('tasks.incomplete', $task->id)}}" class="">Mark as incomplete</a>
                @else
                    <a href="{{route('tasks.complete', $task->id)}}" class="">Mark as complete</a>
                @endif
            </div>
    

            <hr>
            {{--  Edit Task Button  --}}
            <div class=""><a href="/tasks/{{$task->id}}/edit" class="">Edit</a></div>

            {{--  Delete Task Button  --}}
            <div class="">
                {!! Form::open(['action' => ['TasksController@destroy', $task->id], 'method' => 'POST']) !!}
                    {{Form::hidden('_method', 'DELETE')}}
                    {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
                {!! Form::close() !!}
            </div>


        </div>
    </div>



    