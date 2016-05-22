@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ $typeName }}</div>
                    {{ debug( $action ) }}
                    <div class="panel-body">
                        {{ Form::model( $instance, $options ) }}
                        <div class="form-group{{ $errors->has('slug') ? ' has-error' : '' }}">
                        {{ Form::label( 'slug', 'Slug', ['class' => 'col-md-12 control-label'] ) }}
                            <div class="col-md-12">
                            {{ Form::input( 'text', 'slug', request()->old('slug'), ['class' => 'form-control']  ) }}
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('body') ? ' has-error' : '' }}">
                        {{ Form::label( 'body', 'Body', ['class' => 'col-md-12 control-label'] ) }}
                            <div class="col-md-12">
                            {{ Form::textarea( 'body', $body, ['class' => 'form-control'] ) }}
                            </div>
                        </div>
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
