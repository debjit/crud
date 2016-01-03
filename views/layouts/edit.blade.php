@extends('crud::master-no-control')

@section('subheader')
    {{--
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">{{ trans('crud::form.title.edit-model', ['model' => $MasterInstance->getModelSingularName()]) }}</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    --}}
    <!-- /.row -->
    <section class="content-header">
        <h1>
            {{ trans('crud::form.title.edit-model', ['model' => $MasterInstance->getModelSingularName()]) }}
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{URL::route('crud.home')}}"><i class="fa fa-dashboard"></i> {{trans('crud::views.dashboard.title')}}</a></li>
            <li><a href="{{ route('crud.index', $ModelName) }}"><i class="fa fa-list"></i> {{ trans('crud::index.list-title', ['model' => $MasterInstance->getModelPluralName()]) }}</a></li>
            <li class="active"><i class="fa fa-edit"></i>  {{ trans('crud::form.title.edit-model', ['model' => $MasterInstance->getModelSingularName()]) }}</li>
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
    {!! CRUDForm::open(['method' => 'PUT', 'route' => ['crud.update', $ModelName, $id], 'class' => 'form-horizontal', 'files' => true]) !!}

    <input type="hidden" name="{{ \Illuminate\Support\Str::singular($MasterInstance->getTable()) }}_id" value="{{ $id }}">

    @include('crud::partials._form')
    {!! CRUDForm::close() !!}
@stop