@extends('layouts.create_edit')

@section('form_fields')
    <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
        {{ Form::label( 'title', 'Title', ['class' => 'col-md-12 control-label'] ) }}
        <div class="col-md-12">
            @if ($errors->has('title'))
                <span class="help-block">
            <strong>{{ $errors->first('title') }}</strong>
        </span>
            @endif
            {{ ($title = request()->old('title')) ? '':'' }}
            @if($action == 'update' && empty($title))
                {{ ($title = $instance->text->title) ? '':'' }}
            @endif
            {{ Form::input( 'text', 'title', $title, ['class' => 'form-control'] ) }}
        </div>
    </div>
    <div class="form-group{{ $errors->has('completed') ? ' has-error' : '' }}">
        {{ Form::label( 'completed', 'Completed?', ['class' => 'col-md-12 control-label'] ) }}
        <div class="col-md-12">
            @if ($errors->has('completed'))
                <span class="help-block">
            <strong>{{ $errors->first('completed') }}</strong>
        </span>
            @endif
            {{ ($completed = request()->old('completed', 0)) ? '':'' }}
            @if($action == 'update' && empty($completed))
                {{ ($completed = $instance->text->completed) ? '':'' }}
            @endif
            {{ Form::checkbox( 'completed', 1, $completed, ['class' => 'form-control', 'data-toggle' => 'toggle'] ) }}
        </div>
    </div>
    <div class="form-group{{ $errors->has('body') ? ' has-error' : '' }}">
        {{ Form::label( 'body', 'Body', ['class' => 'col-md-12 control-label'] ) }}
        <div class="col-md-12">
            @if ($errors->has('body'))
                <span class="help-block">
            <strong>{{ $errors->first('body') }}</strong>
        </span>
            @endif
            {{ ($body = request()->old('body')) ? '':'' }}
            @if($action == 'update' && empty($body))
                {{ ($body = $instance->text->body) ? '':'' }}
            @endif
            {{ Form::textarea( 'body', $body, ['class' => 'form-control'] ) }}
        </div>
    </div>
@endsection
