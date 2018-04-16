@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="card">
                <div class="card-header">
                    Note |
                    @if(Auth::user() && Auth::user()->id == $note->user->id)
                        <a href="{{ route($type.'.edit', $note->slug) }}" title="Edit Note">Edit</a>
                    @endif
                </div>
                <div class="card-body">
                    By: <strong>{{ $note->user->name }}</strong>
                    <p>{{ $note->text->body }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
