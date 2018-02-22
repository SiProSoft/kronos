
<div class="floating-timer-button {{ $runningTimeEntry ? '__stop' : '__start' }}">

    
    @if ($runningTimeEntry)
        <div class="floating-timer-button--display-text">
            <div>{{ $runningTimeEntry->task->title }}</div>
            <div>{{ $runningTimeEntry->task->project->title }}</div>
        </div>

    @else
        <div class="floating-timer-button--options-button">
            <a href="#">
                <i class="material-icons">more_vert</i>
            </a>
        </div>
    @endif
    

    @if ($runningTimeEntry)
        <a href="{{ route('timer.stop') }}" class="main-button" >
            <i class="material-icons">stop</i>
        </a>
    @else
        <a href="{{ route('timer.start') }}" class="main-button" >
            <i class="material-icons">play_arrow</i>
        </a>
    @endif

    
    
    {{--  
        
            @if ($runningTimeEntry)
                <div class="pull-left nav--timer__details">
                    <div>{{ $runningTimeEntry->task->title }}</div>
                    <div>{{ $runningTimeEntry->task->project->title }}</div>
                </div>
            @endif
        --}}
            {{--  <div class="pull-right">
                @if ($runningTimeEntry)
                    @include('inc.timer.stop')
                @else
                    @include('inc.timer.start', ['taskId' => auth()->user()->getDefaultProject()->getDefaultTask()->id])
                @endif
            </div>  --}}


        {{--  floating timerbutton  --}}
        

</div>
