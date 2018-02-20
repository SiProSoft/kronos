@auth

{{--  TODO: Remove style attribute  --}}
<div class="nav--timer pull-right" style="margin: 5px 0;">

    @if ($runningTimeEntry)
    <div class="pull-left nav--timer__details">
        <div>{{ $runningTimeEntry->task->title }}</div>
        <div>{{ $runningTimeEntry->task->project->title }}</div>
    </div>
    @endif

    <div class="pull-right">
        @if ($runningTimeEntry)
            @include('inc.timer.stop')
        @else
            @include('inc.timer.start', ['taskId' => auth()->user()->getDefaultProject()->getDefaultTask()->id])
        @endif
    </div>
</div>

@endauth