@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $typeName }}</div>

                <div class="panel-body">
                    <ul>
                        @foreach($all as $note)
                            <li><a href="{{ route($type.'.show', $note->slug ) }}" title="{{ str_limit($note->text->body, 20) }}">{{ str_limit($note->text->body, 20) }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
