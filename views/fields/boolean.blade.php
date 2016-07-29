@if($field->getContext() === \BlackfyreStudio\CRUD\Fields\BaseField::CONTEXT_INDEX)

    @if($field->getValue() == 1)
        <i class="fa fa-fw fa-check"></i>
        @else
        <i class="fa fa-fw fa-times"></i>
    @endif

    @else

    <div class="form-group">
        <label class="col-sm-3 control-label">{{ $field->getLabel() }}</label>
        <div class="col-sm-9">
            <div class="checkbox">
                <label>
                    {!! CRUDForm::checkbox($field->getName(), 1, $field->getValue(),$field->getAttributes()) !!}
                </label>
            </div>
            @if ($field->getDescription())
                <p class="help-block">{!! $field->getDescription() !!}</p>
            @endif
        </div>
    </div>

@endif