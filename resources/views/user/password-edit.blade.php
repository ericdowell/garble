@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="card">
                    <div class="card-header">Change User Password</div>
                    <div class="card-body">
                        <div class="col-md-12 mb-2">
                            <h5>User Details</h5>
                            <strong>Name:</strong> {{ $user->name }},
                            <strong>Email Address:</strong> {{ $user->email }},
                            @if($user->username)
                                <strong>Username:</strong> {{ $user->username }}
                            @endif
                        </div>
                        {{ Form::model($user, $options) }}
                        <div class="form-group{{ $errors->has('current_password') ? ' has-error' : '' }}">
                            {{ Form::label('current_password', 'Current Password', ['class' => 'col-md-12 control-label', 'required' => 'required']) }}
                            <div class="col-md-12">
                                @if ($errors->has('current_password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('current_password') }}</strong>
                                    </span>
                                @endif
                                {{ Form::password('current_password', ['class' => 'form-control']) }}
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            {{ Form::label('password', 'Password', ['class' => 'col-md-12 control-label', 'required' => 'required']) }}
                            <div class="col-md-12">
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                                {{ Form::password('password', ['class' => 'form-control']) }}
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            {{ Form::label('password_confirmation', 'Password Confirmation', ['class' => 'col-md-12 control-label']) }}
                            <div class="col-md-12">
                                {{ Form::password('password_confirmation', ['class' => 'form-control']) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                {{ Form::submit('Change Password', ['class' => 'btn btn-primary', 'required' => 'required']) }}
                            </div>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
