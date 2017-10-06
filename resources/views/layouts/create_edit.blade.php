@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ $formHeader }}</div>
                    <div class="panel-body">
                        {{ Form::model( $instance, $options ) }}
                        {{ Form::hidden('text_type', $type) }}
                        {{ Form::hidden('user_id', Auth::user()->id) }}
                        @if($action == 'update')
                            {{ Form::hidden('text_id', $instance->text_id) }}
                        @endif
                        <div class="form-group{{ $errors->has('slug') ? ' has-error' : '' }}">
                            {{ Form::label( 'slug', 'Slug', ['class' => 'col-md-12 control-label'] ) }}
                            <div class="col-md-12">
                                @if ($errors->has('slug'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('slug') }}</strong>
                                </span>
                                @endif
                                {{ Form::input( 'text', 'slug', request()->old('slug'), ['class' => 'form-control']  ) }}
                            </div>
                        </div>

                        @yield('form_fields')

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                {{ Form::submit( $btnMessage, [ 'class' => 'btn btn-primary' ] ) }}
                            </div>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

