@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $typeName }}</div>
                <div class="panel-body">
                    <ul>
                    @if( $all->count() != 0 )
                    @foreach($all as $post)
                        <li>
                            <a href="{{ route($type.'.show', $post->slug ) }}" title="{{ $post->text->title }}">{{ $post->text->title }}</a>
                            @if(Auth::user() && Auth::user()->id == $post->user->id)
                            <a class="btn btn-link" href="{{ route($type.'.edit', $post->slug) }}">Edit</a>
                            @include('include.delete_form', ['title' => $post->text->title , 'instance' => $post])
                            @endif
                        </li>
                    @endforeach
                    @else
                        <li>No {{ $typeName }} Found</li>
                    @endif
                    </ul>
                    @if(Auth::user())
                    <a class="btn btn-primary" href="{{ route($type.'.create') }}">Create {{ $typeName }}</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
