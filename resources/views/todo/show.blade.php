@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $todo->text->title }}</div>

                <div class="panel-body">
                    @if(Auth::user() && Auth::user()->id == $todo->user->id)
                        <p>
                            <a class="btn btn-link" href="{{ route($type.'.edit', $todo->slug) }}">Edit</a>
                        </p>
                    @endif
                    Assigned To: <strong>{{ $todo->user->name }}</strong>
                    <p>Task Status: {{ $todo->text->completed ? 'Done' : 'Not Completed' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
