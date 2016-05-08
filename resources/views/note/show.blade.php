@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Note</div>

                <div class="panel-body">
                    By: <strong>{{ $note->user->name }}</strong>
                    <p>{{ $note->text->body }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
