<?php
/**
 * @var \BlackfyreStudio\CRUD\Fields\SelectField $field
 */
?>
<div class="form-group {{ $errors->has($field->getName()) ? 'has-error' : '' }}">
    <label class="col-sm-3 control-label">{{ $field->getLabel() }}</label>
    <div class="col-sm-9">

        {!! CRUDForm::select($field->getName(), $field->getOptions(), $field->getValue(), $field->getAttributes()) !!}

        @if ($field->getDescription())
            <p class="help-block">{{ $field->getDescription() }}</p>
        @endif
    </div>
</div>