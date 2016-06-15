<?php
/**
 * @var \BlackfyreStudio\CRUD\Fields\ImageField $field
 */
?>

@if($field->getContext() === \BlackfyreStudio\CRUD\Fields\BaseField::CONTEXT_INDEX)

    @if ($field->getValue() !== null && is_array($field->getValue()))
    <button data-provide="gallery" data-target="#gallery-{{$field->getName()}}" class="btn btn-link btn-xs" title="{{trans('crud::index.button.open-gallery')}}"><i class="fa fa-fw fa-picture-o"></i></button>
    <div id="gallery-{{$field->getName()}}">

        @foreach($field->getValue() as $size=>$image)
            <a class="preload" href="{{ asset($image['src']) }}" title="{{$size}}"></a>
        @endforeach

    </div>
    @endif

    @else

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
            
                @if ($field->getDescription())
                    <p class="help-block">{{ $field->getDescription() }}</p>
                @endif
            @else
                {!!  CRUDForm::file($field->getName(), $field->getAttributes()) !!}

                @if ($field->getDescription())
                    <p class="help-block">{{ $field->getDescription() }}</p>
                @endif

                @if ($field->getValue() !== null && is_array($field->getValue()))
                    <button data-provide="gallery" data-target="#gallery-{{$field->getName()}}" class="btn btn-primary btn-xs" style="margin-top: 10px" title="{{trans('crud::index.button.open-gallery')}}"><i class="fa fa-fw fa-picture-o"></i> Preview uploaded</button>
                    <div id="gallery-{{$field->getName()}}">

                        @foreach($field->getValue() as $size=>$image)
                            <a class="preload" href="{{ asset($image['src']) }}" title="{{$size}}"></a>
                        @endforeach

                    </div>
                 @endif

            @endif

        </div>
    </div>

@endif

