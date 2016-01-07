<?php
/**
 * @var \BlackfyreStudio\CRUD\Master $MasterInstance
 * @var \BlackfyreStudio\CRUD\Fields\BaseField $field
 */
?>
@if ($MasterInstance->getFormPlanner()->hasTabs())
<div class="">
    @else
<div class="row">
@endif
    <div class="col-sm-8">
        @if ($MasterInstance->getFormPlanner()->hasTabs())
            <div class="">
            @else
            <div class="row">
        @endif
            @if ($MasterInstance->getFormPlanner()->hasTabs())
                <div class="nav-tabs-custom">
                @else
                <div class="box-body">
            @endif

                @if ($MasterInstance->getFormPlanner()->hasTabs())
                    <ul class="nav nav-tabs">
                        @foreach ($MasterInstance->getFormPlanner()->getTabs() as $key => $tab)
                            <li>
                                <a href="#tab-{{ $key }}" data-toggle="tab">{{ $tab }}</a>
                            </li>
                        @endforeach
                    </ul>
                @endif

                @if ($MasterInstance->getFormPlanner()->hasTabs())
                    <div class="tab-content crud-form">
                        @foreach ($MasterInstance->getFormPlanner()->getTabs() as $key => $tab)
                            <div class="tab-pane" id="tab-{{ $key }}">
                                @foreach ($MasterInstance->getFormBuilder()->getResult()->getFields() as $field)
                                    @if ($field->getTab() === $tab && $field->getPosition() === 'left')
                                        {!! $field->render() !!}
                                    @endif
                                @endforeach

                                <div class="box-footer">
                                    <div class="row">
                                        <div class="col-sm-9 col-sm-offset-3"><input type="submit" class="btn btn-primary" value="{{ trans('crud::form.button.save', ['model' => $MasterInstance->getModelSingularName()]) }}"></div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    @foreach ($MasterInstance->getFormBuilder()->getResult()->getFields() as $field)
                        @if ($field->getPosition() === 'left')
                            {!! $field->render() !!}
                        @endif
                    @endforeach
                @endif
            </div>

            @if (!$MasterInstance->getFormPlanner()->hasTabs())
                <div class="box-footer">
                    <div class="row">
                        <div class="col-sm-9 col-sm-offset-3"><input type="submit" class="btn btn-primary" value="{{ trans('crud::form.button.save', ['model' => $MasterInstance->getModelSingularName()]) }}"></div>
                    </div>
                </div>
            @endif

        </div>
    </div>
    <div class="col-sm-4">
        @if ($MasterInstance->getFormPlanner()->hasFieldsOnPosition('right'))
            <div class="box">
                <div class="box-body">
                    @foreach ($MasterInstance->getFormBuilder()->getResult()->getFields() as $field)
                        @if ($field->getPosition() === 'right')
                            {!! $field->render() !!}
                        @endif
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>