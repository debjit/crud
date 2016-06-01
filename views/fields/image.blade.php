<?php
/**
 * @var \BlackfyreStudio\CRUD\Fields\ImageField $field
 */
?>
<div class="form-group {{ $errors->has($field->getName()) ? 'has-error' : '' }}">
    <label class="col-sm-3 control-label">{{ $field->getLabel() }}</label>
    <div class="col-sm-9">

        @if ($field->checkIfMultiple())
            <div class="row">
                @foreach ($field->getValue() as $key => $value)

                    <div class="col-sm-3" data-multiply>
                        <div class="image-file-wrapper">
                            {{ CRUDForm::file($field->getName() . '[]', $field->getAttributes()) }}

                            @if ($value)
                                <div class="image-preview" style="background-image: url('{{ asset($value) }}');"></div>
                            @else
                                <div class="image-preview"></div>
                            @endif

                            <div class="field-infinite">
                                <a data-event="field-add" style="{{ $key != count($field->getValue()) -1 ? 'display: none;' : '' }}">
                                    <i class="fa fa-plus"></i>
                                </a>

                                <a data-event="field-remove" style="{{ $key == count($field->getValue()) -1 ? 'display: none;' : '' }}">
                                    <i class="fa fa-times"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                @endforeach
            </div>
        @else
            {{ CRUDForm::file($field->getName(), $field->getAttributes()) }}
            @if ($field->getValue() !== null && is_array($field->getValue()))
                @foreach($field->getValue() as $size=>$image)
                <div class="row">
                    <div class="col-sm-12">
                        <img src="{{ asset($image) }}" title="{{$size}}" class="img-responsive">
                    </div>
                </div>
                @endforeach
            @endif
        @endif

    </div>
</div>