<div class="more-group">
    <a href="#" class="more-group--button ic-more">
        <img src="{{ asset('img/icon/ic-more.svg') }}" alt="More icon">
    </a>

    <div class="more-group--list">
        <div>
            <a href="{{route('projects.edit', $project->id)}}" class="btn btn-default">Edit</a>
        </div>

        <div>
            {!! Form::open(['action' => ['ProjectsController@destroy', $project->id], 'method' => 'POST']) !!}
                {{ Form::submit('Delete', ['class' => 'btn btn-danger']) }}
                {{ Form::hidden('_method', 'DELETE') }}
            {!! Form::close() !!}
        </div>

        <div>
            
            @if ($runningTimeEntry && $runningTimeEntry->getProject()->id == $project->id)
                @include('inc.timer.stop', ['runningTimeEntry' => $runningTimeEntry, 'labelText' => 'Stop timer'])
            
                {{--  @if ($runningTimeEntry->getProject()->id == $project->id)
                    @include('inc.timer.stop', ['runningTimeEntry' => $runningTimeEntry])
                @else
                    @include('inc.timer.start', ['taskId' => $project->getDefaultTask()->id, 'labelText' => 'Start project'])
                @endif  --}}
            @else
                @include('inc.timer.start', ['taskId' => $project->getDefaultTask()->id, 'labelText' => 'Start project'])
                {{--  {{$project->getDefaultTask()->id}}  --}}
            @endif
        </div>
    </div>
</div>