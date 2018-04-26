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
                        <th>Name</th>
                        <th>Email/Username</th>
                        <th>Edit</th>
                        <th>Password</th>
                        <th>Delete</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if( $models->count() != 0 )
                    @foreach($models as $user)
                        <tr>
                            <td><a href="{{ route($type.'.show', $user->id) }}" title="{{ $user->name }}">{{ $user->name  }}</a></td>
                            <td><strong>{{ $user->email }}@if(!empty($user->username))/{{ $user->username }}@endif</strong></td>
                            <td><small><a class="btn btn-info btn-sm" href="{{ route($type.'.edit', $user->id) }}">Edit</a></small></td>
                            <td><small><a class="btn btn-info btn-sm" href="{{ route($type.'.password-edit', $user->id) }}">Change Password</a></small></td>
                            <td>@include('include.delete_form', ['title' => $user->name.' ('.$user->email.')', 'instance' => $user])</td>
                        </tr>
                    @endforeach
                    @else
                        <tr>
                            <td>No {{ $typeName }} Found</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        <tr>
                    @endif
                    </tbody>
                </table>
            </div>
            {{ $models }}
            <a class="btn btn-primary" href="{{ route($type.'.create') }}">Create {{ $typeName }}</a>
        </div>
    </div>
</div>
@endsection
