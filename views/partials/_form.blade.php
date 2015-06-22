<?php
/**
 * @var \BlackfyreStudio\CRUD\Master $MasterInstance
 * @var \BlackfyreStudio\CRUD\Fields\BaseField $field
 */
?>
<div class="row">
    <div class="col-sm-8">
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
            <div class="tab-content">
                @foreach ($MasterInstance->getFormPlanner()->getTabs() as $key => $tab)
                    <div class="tab-pane" id="tab-{{ $key }}">
                        @foreach ($MasterInstance->getFormBuilder()->getResult()->getFields() as $field)
                            @if ($field->getTab() == $tab && $field->getPosition() == 'left')
                                {!! $field->render() !!}
                            @endif
                        @endforeach
                    </div>
                @endforeach
            </div>
        @else
            @foreach ($MasterInstance->getFormBuilder()->getResult()->getFields() as $field)
                @if ($field->getPosition() == 'left')
                    {!! $field->render() !!}
                @endif
            @endforeach
        @endif

    </div>
    <div class="col-sm-4">
        @if ($MasterInstance->getFormPlanner()->hasFieldsOnPosition('right'))
            <div class="panel panel-default">
                <div class="panel-body">
                    @foreach ($MasterInstance->getFormBuilder()->getResult()->getFields() as $field)
                        @if ($field->getPosition() == 'right')
                            {!! $field->render() !!}
                        @endif
                    @endforeach
                </div>
            </div>
        @endif

        <div class="col-sm-12">
            <input type="submit" class="btn btn-default btn-red btn-rounded" value="{{ trans('crud::form.button.save', ['model' => $MasterInstance->getModelSingularName()]) }}">
        </div>
    </div>
</div>