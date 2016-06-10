@if($MasterInstance->getFormPlanner()->hasTabs())

    @foreach ($MasterInstance->getFormBuilder()->getResult()->getFields() as $field)
        @if ($field->getTab() === $tab && $field->getPosition() === $fieldPosition)
            {!! $field->render() !!}
        @endif
    @endforeach

    @else

    @foreach ($MasterInstance->getFormBuilder()->getResult()->getFields() as $field)
        @if ($field->getPosition() === $fieldPosition)
            {!! $field->render() !!}
        @endif
    @endforeach

@endif

