@if ($MasterInstance->getFormPlanner()->hasFieldsOnPosition('right'))

    <div class="row">
        <div class="col-sm-8">

            @include('crud::partials._form-tabs')

        </div>
        <div class="col-sm-4">

            @include('crud::partials._form-field',['fieldPosition'=>'right'])

        </div>
    </div>

    @else

    @include('crud::partials._form-tabs')

@endif

