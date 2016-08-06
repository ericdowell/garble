{{ ($formName = 'form-'.$type.'-'.$instance->text->id) ? '':'' }}
{{ ($linkOptions = [
        'class' => 'btn btn-link',
        'onclick' => 'confirmDelete(this);',
        'data-title' => $title,
        'data-form-name' => $formName
    ]) ? '':'' }}
{{ Html::link( '#' , 'Delete' , $linkOptions) }}
{{ Form::model( $instance, ['route' => [$type.'.destroy', $instance->slug], 'method' => 'delete', 'id' => $formName, 'style' => 'display:none;'] ) }}
    {{ Form::submit( 'Delete', [ 'class' => 'btn btn-link' ] ) }}
{{ Form::close() }}
