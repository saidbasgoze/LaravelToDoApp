@extends("layouts.app")

@section("title", "The List of Tasks")

@section("content")
<nav class="mb-10">
<a href="{{route("tasks.create")}}" class="link" >Add Task!</a>
</nav>

<div>
    @if(count($tasks))
        @foreach($tasks as $task)
        <div>
        <a href="{{ route('tasks.show', ['task' => $task->id]) }}"
   @class([ 'line-through' => $task->completed])>
   {{ $task->title }}
</a>
    <!-- task completed olduğunda altını çöz -->
</div>
        @endforeach
    @else
        <div>There are no tasks!</div>
    @endif

    @if(isset($tasks) && $tasks->count() > 0)
        <div>{{ $tasks->links() }}</div>
    @endif
</div>

@endsection
