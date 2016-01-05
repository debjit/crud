<?php
/** @var \BlackfyreStudio\CRUD\Fields\PasswordField $field */
?>
<div class="form-group {{ $errors->has($field->getName()) ? 'has-error' : '' }}">
    <label class="col-sm-3 control-label">{{ $field->getLabel() }}</label>
    <div class="col-sm-9">
        {!! CRUDForm::password($field->getName(), $field->getAttributes()) !!}
    </div>
</div>

<div class="form-group {{ $errors->has($field->getName()) ? 'has-error' : '' }}">
    <label class="col-sm-3 control-label">{{ trans('crud::user.passwordConfirm', ['password'=>$field->getLabel()]) }}</label>
    <div class="col-sm-9">
        {!! CRUDForm::password($field->getName() . '_confirm', $field->getAttributes()) !!}
    </div>
</div>