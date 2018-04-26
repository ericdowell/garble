@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="card">
                    <div class="card-header">{{ $formHeader }}</div>
                    <div class="card-body">
                        {{ Form::model($user, $options) }}
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            {{ Form::label('name', 'Name', ['class' => 'col-md-12 control-label']) }}
                            <div class="col-md-12">
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                                {{ ($name = request()->old('name')) ? '':'' }}
                                @if($action == 'update' && empty($name))
                                    {{ ($name = $user->name) ? '':'' }}
                                @endif
                                {{ Form::text('name', $name, ['class' => 'form-control', 'required' => 'required']) }}
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                            {{ Form::label('username', 'Username (Optional)', ['class' => 'col-md-12 control-label']) }}
                            <div class="col-md-12">
                                @if ($errors->has('username'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                @endif
                                {{ ($username = request()->old('username')) ? '':'' }}
                                @if($action == 'update' && empty($username))
                                    {{ ($username = $user->username) ? '':'' }}
                                @endif
                                {{ Form::text('username', $username, ['class' => 'form-control']) }}
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            {{ Form::label('email', 'Email Address', ['class' => 'col-md-12 control-label']) }}
                            <div class="col-md-12">
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                                {{ ($email = request()->old('email')) ? '':'' }}
                                @if($action == 'update' && empty($email))
                                    {{ ($email = $user->email) ? '':'' }}
                                @endif
                                {{ Form::email('email', $email, ['class' => 'form-control', 'required' => 'required']) }}
                            </div>
                        </div>
                        @if($action == 'update')
                        <div class="form-group{{ $errors->has('current_password') ? ' has-error' : '' }}">
                            {{ Form::label('current_password', 'Current Password', ['class' => 'col-md-12 control-label']) }}
                            <div class="col-md-12">
                                @if ($errors->has('current_password'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('current_password') }}</strong>
                                </span>
                                @endif
                                {{ Form::password('current_password', ['class' => 'form-control', 'required' => 'required']) }}
                            </div>
                        </div>
                        @else
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            {{ Form::label('password', 'Password', ['class' => 'col-md-12 control-label']) }}
                            <div class="col-md-12">
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                                {{ Form::password('password', ['class' => 'form-control', 'required' => 'required']) }}
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            {{ Form::label('password_confirmation', 'Password Confirmation', ['class' => 'col-md-12 control-label']) }}
                            <div class="col-md-12">
                                {{ Form::password('password_confirmation', ['class' => 'form-control', 'required' => 'required']) }}
                            </div>
                        </div>
                        @endif

                        @yield('form_fields')

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                {{ Form::submit($btnMessage, [ 'class' => 'btn btn-primary' ]) }}
                            </div>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
