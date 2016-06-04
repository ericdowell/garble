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
                    @foreach($all as $todo)
                        <li>
                            <a href="{{ route($type.'.show', $todo->slug ) }}" title="{{ $todo->text->title }}">{{ $todo->text->title }}</a>
                            @if(Auth::user() && Auth::user()->id == $note->user->id)
                                <a class="btn btn-link" href="{{ route($type.'.edit', $note->slug) }}">Edit</a>
                                {{ Form::model( $note, ['route' => [$type.'.destroy', $note->slug], 'method' => 'delete'] ) }}
                                {{ Form::submit( 'Delete', [ 'class' => 'btn btn-link' ] ) }}
                                {{ Form::close() }}
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
