@if ($MasterInstance->getFormPlanner()->hasTabs())

    <ul class="nav nav-tabs">
        <?php $tabCounter = 0 ?>

        @foreach ($MasterInstance->getFormPlanner()->getTabs() as $key => $tab)
            <li  @if($tabCounter == 0) class="active" @endif>
                <a href="#tab-{{ $key }}" data-toggle="tab">{{ $tab }}</a>
            </li>

                <?php $tabCounter++ ?>
        @endforeach
    </ul>

    <div class="tab-content">

        <?php $tabCounter = 0 ?>

        @foreach ($MasterInstance->getFormPlanner()->getTabs() as $key => $tab)
            <div class="tab-pane crud-form @if($tabCounter == 0) active @endif" id="tab-{{ $key }}">
                @include('crud::partials._form-field',['fieldPosition'=>'left'])
            </div>

            <?php $tabCounter++ ?>

        @endforeach
    </div>

@else

    @include('crud::partials._form-field',['fieldPosition'=>'left'])

@endif