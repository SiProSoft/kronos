@auth

<div class="nav--timer pull-right">
    @if ($runningTimeEntry)
        @include('inc.timer.stop')
    @else
        @include('inc.timer.start', ['taskId' => auth()->user()->getDefaultProject()->getDefaultTask()->id])
    @endif
</div>

@endauth