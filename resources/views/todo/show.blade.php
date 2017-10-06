@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong>{{ $todo->text->title }}</strong> |
                    @if(Auth::user() && Auth::user()->id == $todo->user->id)
                        <a href="{{ route($type.'.edit', $todo->slug) }}" title="Edit {{ $todo->text->title }}">Edit</a>
                    @endif
                </div>
                <div class="panel-body">
                    <strong>Task:</strong>
                    <p>{{ $todo->text->completed ? 'Done' : 'Not Completed' }}</p>
                    <strong>Assigned To:</strong>
                    <p>{{ $todo->user->name }}</p>
                    @if($todo->text->body)
                    <strong>Body:</strong>
                    <p>{{ $todo->text->body }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
