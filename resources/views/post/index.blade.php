@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <h1>{{ $typeName }}</h1>
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>Title</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if( $all->count() != 0 )
                    @foreach($all as $post)
                        <tr>
                            <td><a href="{{ route($type.'.show', $post->slug ) }}" title="{{ $post->text->title }}">{{ $post->text->title }}</a></td>

                            @if(Auth::user() && Auth::user()->id == $post->user->id)
                            <td><small><a class="btn btn-info btn-sm" href="{{ route($type.'.edit', $post->slug) }}">Edit</a></small></td>
                            <td><small>@include('include.delete_form', ['title' => $post->text->title , 'instance' => $post])</small></td>
                            @else
                            <td></td>
                            <td></td>
                            @endif
                        </tr>
                    @endforeach
                    @else
                        <tr>
                            <td>No {{ $typeName }} Found</td>
                            <td></td>
                            <td></td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
            {{ $all }}
            @if(Auth::user())
                <a class="btn btn-primary" href="{{ route($type.'.create') }}">Create {{ $typeName }}</a>
            @endif
        </div>
    </div>
</div>
@endsection
