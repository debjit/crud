@if(\Auth::user()->hasPermission($field->getMasterInstance()->getModelBaseName() . '.edit'))

    <strong><a href="{{ route('crud.edit', [$field->getMasterInstance()->getModelBaseName(), $field->getValue()]) }}">{{$field->getValue()}}</a></strong>

    @else

    <strong>{{$field->getValue()}}</strong>

@endif

