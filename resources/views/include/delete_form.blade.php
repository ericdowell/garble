{{ ($formName = 'form-'.$type.'-'.$instance->id) ? '':'' }}
{{ ($linkOptions = [
        'class' => 'btn btn-danger btn-sm',
        'title' => $title,
        'onclick' => 'confirmDelete(this);',
        'data-title' => $title,
        'data-form-name' => $formName
    ]) ? '':'' }}
{{ Html::link( '#' , 'Delete' , $linkOptions) }}
{{ Form::model( $instance, ['route' => [$type.'.destroy', $instance->getKey()], 'method' => 'delete', 'id' => $formName, 'style' => 'display:none;'] ) }}
    {{ Form::submit( 'Delete', [ 'class' => 'btn btn-link' ] ) }}
{{ Form::close() }}
