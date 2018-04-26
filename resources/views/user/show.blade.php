@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="card">
                <div class="card-header">
                    <strong>{{ $user->name }}</strong> |
                    <a href="{{ route($type.'.edit', $user->id) }}" title="Edit {{ $user->name }}">Edit</a>
                </div>
                <div class="card-body">
                    <strong>Name:</strong>
                    <p>{{ $user->name }}</p>
                    <strong>Email Address:</strong>
                    <p>{{ $user->email }}</p>
                    @if($user->username)
                    <strong>Username:</strong>
                    <p>{{ $user->username }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
