@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $post->text->title }}</div>

                <div class="panel-body">
                    @if(Auth::user() && Auth::user()->id == $post->user->id)
                        <p>
                            <a class="btn btn-link" href="{{ route($type.'.edit', $post->slug) }}">Edit</a>
                        </p>
                    @endif
                    By: <strong>{{ $post->user->name }}</strong>
                    <p>{{ $post->text->body }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
