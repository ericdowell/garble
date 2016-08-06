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
                    @foreach($all as $note)
                        <li>
                            <a href="{{ route($type.'.show', $note->slug ) }}" title="{{ str_limit($note->text->body, 20) }}">{{ str_limit($note->text->body, 20) }}</a>
                            @if(Auth::user() && Auth::user()->id == $note->user->id)
                            <a class="btn btn-link" href="{{ route($type.'.edit', $note->slug) }}">Edit</a>
                            @include('include.delete_form', ['title' => str_limit($note->text->body, 20), 'instance' => $note])
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
