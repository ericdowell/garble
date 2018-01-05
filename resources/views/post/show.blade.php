@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="card">
                <div class="card-header">
                    <strong>{{ $post->text->title }}</strong> |
                    @if(Auth::user() && Auth::user()->id == $post->user->id)
                        <a href="{{ route($type.'.edit', $post->slug) }}" title="Edit {{ $post->text->title }}">Edit</a>
                    @endif
                </div>
                <div class="card-body">
                    By: <strong>{{ $post->user->name }}</strong>
                    <p>{{ $post->text->body }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
