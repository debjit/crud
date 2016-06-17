@extends('crud::master')


@section('content')

    <div class="container-fluid breadcrumb-container">
        <div class="container">
            <ol class="breadcrumb">
                <li><a href="{{URL::route('crud.home')}}"><i class="fa fa-fw fa-dashboard"></i>{{trans('crud::views.dashboard.title')}}</a></li>
                <li><a href="{{ route('crud.index', $ModelName) }}"><i class="fa fa-list"></i> {{ trans('crud::index.list-title', ['model' => $MasterInstance->getModelPluralName()]) }}</a></li>
                <li class="active"><i class="fa fa-plus"></i>  {{ trans('crud::form.title.create-model', ['model' => $MasterInstance->getModelSingularName()]) }}</li>
            </ol>
        </div>
    </div>

    <div class="container sceneElement" data-transition="moveleft">

        @include('crud::partials._session-messages')

    @if ($MasterInstance->getFormPlanner()->hasFieldsOnPosition('right'))

        {!! CRUDForm::open(['route' => ['crud.store', $ModelName], 'class' => 'form-horizontal', 'files' => true]) !!}

        <div class="panel panel-default"> <!-- Panel -->
            <div class="panel-heading">
                <h3 class="panel-title">{{ trans('crud::form.title.create-model', ['model' => $MasterInstance->getModelSingularName()]) }}</h3>
            </div>
            <div class="panel-body">
                @include('crud::partials._form')
            </div>
            <div class="panel-footer">
                <button type="submit" class="btn btn-success">Create / Update</button>
                {!! CRUDForm::submit(trans('crud::form.button.save', ['model' => $MasterInstance->getModelSingularName()]),['class'=>'btn btn-success']) !!}
            </div>
        </div>

        {!! CRUDForm::close() !!}

        @else


        <div class="row">
            <div class="col-sm-8 col-sm-offset-2">

                {!! CRUDForm::open(['route' => ['crud.store', $ModelName], 'class' => 'form-horizontal', 'files' => true]) !!}

                <div class="panel panel-default"> <!-- Panel -->
                    <div class="panel-heading">
                        <h3 class="panel-title">{{ trans('crud::form.title.create-model', ['model' => $MasterInstance->getModelSingularName()]) }}</h3>
                    </div>
                    <div class="panel-body">
                        @include('crud::partials._form')
                    </div>
                    <div class="panel-footer">
                        {!! CRUDForm::submit(trans('crud::form.button.save', ['model' => $MasterInstance->getModelSingularName()]),['class'=>'btn btn-success']) !!}
                    </div>
                </div>

                {!! CRUDForm::close() !!}

            </div>
        </div>


    @endif


    </div>


@stop