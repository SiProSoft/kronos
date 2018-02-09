<div class="nav--timer pull-right">
    @if ($runningTimeEntry)
        <a href="/timer/{{ $runningTimeEntry->id }}/stop" class="btn btn-danger">Stop</a>
    @else
        <a href="/timer/start" class="btn btn-success">Start</a>
    @endif
</div>