@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Note</div>

                <div class="panel-body">
                    @if(Auth::user() && Auth::user()->id == $note->user->id)
                        <p>
                            <a class="btn btn-link" href="{{ route($type.'.edit', $note->slug) }}">Edit</a>
                        </p>
                    @endif
                    By: <strong>{{ $note->user->name }}</strong>
                    <p>{{ $note->text->body }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
