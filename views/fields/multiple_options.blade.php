<div class="form-group {{ $errors->has($field->getName()) ? 'has-error' : '' }}">
    <label class="col-sm-3 control-label">{{ $field->getLabel() }}</label>
    <div class="col-sm-9">
        <div class="row">
        @foreach($items as $option=>$label)
            <div class="{{$cell}}">
                <div class="checkbox">
                    <label>
                        {!! CRUDForm::checkbox($field->getName() . '[]',$option,array_key_exists($option,$values)) !!} {{$label}}
                    </label>
                </div>
            </div>
        @endforeach
        </div>

        @if ($field->getDescription())
            <p class="help-block">{{ $field->getDescription() }}</p>
        @endif
    </div>
</div>