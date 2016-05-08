@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $typeName }}</div>

                <div class="panel-body">
                    <ul>
                        @foreach($all as $todo)
                            <li><a href="{{ route($type.'.show', $todo->slug ) }}" title="{{ $todo->text->title }}">{{ $todo->text->title }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
