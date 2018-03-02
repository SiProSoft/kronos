
@foreach ($tasks as $task)
    <div class="panel panel-default relative">
        <div class="panel-body {{ $task->completed() ? "completed" : ""}} ">
            <span>
                {{ $task->title }}
            </span>

            @if ($viewMode == "tasks")
                <span> - </span>
            
                @if ($task->project->id != auth()->user()->company->getDefaultProject()->id)
                    <a href="{{route('projects.show', $task->project->id )}}">{{ $task->project->title }}</a>
                @else
                    {{ $task->project->title }}
                @endif
            @endif
            <span class="small">
                ({{ $task->displaySum() }})
            </span>

            <div class="pull-right option-menu">

                @include('inc.tasks.more-button', ['task' => $task])
                
            </div>

            @php
            $isEstimated = $task->estimate > 0;
            $color = $task->getProgressInColor();

            $percent = $isEstimated && $task->getProgressInPercent() == 0 ? 100 : $task->getProgressInPercent();
            
            @endphp
            <div class="task-progress" style="width: {{ $percent }}%; background: {{$color}};"></div>
        </div>

        
    </div>
    {{--  <div>Id: {{ $entry->id }}, {{ $entry->displayTime() }}</div>      --}}
@endforeach