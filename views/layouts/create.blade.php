@extends('crud::master-no-control')

@section('subheader')
    <section class="content-header">
        <h1>
            {{ trans('crud::form.title.create-model', ['model' => $MasterInstance->getModelSingularName()]) }}
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{URL::route('crud.home')}}"><i class="fa fa-dashboard"></i> {{trans('crud::views.dashboard.title')}}</a></li>
            <li><a href="{{ route('crud.index', $ModelName) }}"><i class="fa fa-list"></i> {{ trans('crud::index.list-title', ['model' => $MasterInstance->getModelPluralName()]) }}</a></li>
            <li class="active"><i class="fa fa-plus"></i>  {{ trans('crud::form.title.create-model', ['model' => $MasterInstance->getModelSingularName()]) }}</li>
        </ol>
    </section>
@stop

@section('sidebar')
    <ul class="nav nav-sidebar">
        <li>
            <a href="{{ route('crud.index', $ModelName) }}">
                <i class="fa fa-long-arrow-left"></i>
                {{ trans('crud::form.button.back-to-index', ['model' => $MasterInstance->getModelPluralName()]) }}
            </a>
        </li>
        <li>
            <a href="{{ route('crud.create', $ModelName) }}">
                <i class="fa fa-plus"></i>
                {{ trans('crud::index.button.create-new', ['model' => $MasterInstance->getModelSingularName()]) }}
            </a>
        </li>
    </ul>
@stop

@section('content')
    {!! CRUDForm::open(['route' => ['crud.store', $ModelName], 'class' => 'form-horizontal', 'files' => true]) !!}
    @include('crud::partials._form')
    {!! CRUDForm::close() !!}
@stop