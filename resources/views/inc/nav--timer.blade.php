@auth

{{--  TODO: Remove style attribute  --}}
<div class="nav--timer pull-right" style="margin: 7px 0;">
    @if ($runningTimeEntry)
        @include('inc.timer.stop')
    @else
        @include('inc.timer.start', ['taskId' => auth()->user()->getDefaultProject()->getDefaultTask()->id])
    @endif
</div>

@endauth