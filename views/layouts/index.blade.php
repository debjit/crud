@extends('crud::master')

@section('subheader')
    <section class="content-header">
        <h1>
            {{ trans('crud::index.list-title', ['model' => $MasterInstance->getModelPluralName()]) }}
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{URL::route('crud.home')}}"><i
                            class="fa fa-dashboard"></i> {{trans('crud::views.dashboard.title')}}</a></li>
            <li class="active">{{ trans('crud::index.list-title', ['model' => $MasterInstance->getModelPluralName()]) }}</li>
        </ol>
    </section>
@stop

@section('filters')
    @if ($MasterInstance->getFilterBuilder()->getResult()->getFields())
        @include($MasterInstance->getView('filter'))
        @else
        <p>{{trans('crud::index.no-filters')}}</p>
    @endif
@stop

@section('scopes')
    @if ($MasterInstance->getScopePlanner()->hasScopes())
        <ul class="nav nav-sidebar">
            <li class="title">
                <i class="fa fa-search"></i>
                {{ trans('crud::index.sidebar.scopes') }}
            </li>
            @foreach ($MasterInstance->getScopePlanner()->getScopes() as $scope)
                <li>
                    <a href="?_scope={{ $scope->getScope() }}&_filtering=?" class="inset">
                        {{ $scope->getLabel() }}
                    </a>
                </li>
            @endforeach
        </ul>
        @else
        <p>{{trans('crud::index.no-scopes')}}</p>
    @endif
@stop

@section('export')
    @foreach ($MasterInstance->getExportTypes() as $exportType)
        <li>
            <a href="{{ route('crud.export', [$ModelName, $exportType]) }}">{{ $exportType }}</a>
        </li>
    @endforeach
@stop


@section('content')

    @if (Input::has('_filtering'))
        <div class="alert alert-warning">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <strong>{{ trans('crud::messages.warning.title') }}</strong>
            {{ trans('crud::index.browsing-filtered') }}
        </div>
    @endif

    @if (count($MasterInstance->getIndexBuilder()->getResult()) === 0)
        <div class="row">
            <div class="col-sm-4 col-sm-offset-4">
                <div class="panel panel-default">
                    <div class="panel-body text-center">
                        @if (Input::has('_filtering'))
                            <p>{{ trans('crud::index.no-filter-results', ['model' => $MasterInstance->getModelPluralName()]) }}</p>
                            <a class="btn btn-default btn-rounded" href="{{ route('crud.index', $ModelName) }}">
                                {{ trans('crud::index.button.reset-filters') }}
                            </a>
                        @else
                            <p>{{ trans('crud::index.no-items-yet', ['model' => $MasterInstance->getModelPluralName()]) }}</p>
                            <a href="{{ route('crud.create', $ModelName) }}"
                               class="btn btn-default btn-red btn-rounded">
                                <i class="fa fa-plus"></i>
                                {{ trans('crud::index.button.create-new', ['model' => $MasterInstance->getModelSingularName()]) }}
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-sm-{{ $MasterInstance->getFilterBuilder()->getResult()->getFields() ? 8 : 12 }}">
                <div class="box">
                    <div class="box-header">
                        <div class="box-tools">
                            <a class="btn btn-success" href="{{ route('crud.create', $ModelName) }}">
                                <i class="fa fa-plus"></i>
                                {{ trans('crud::index.button.create-new', ['model' => $MasterInstance->getModelSingularName()]) }}
                            </a>
                            <a class="btn btn-primary" href="#" data-toggle="control-sidebar"><i
                                        class="fa fa-gears"></i> Options</a>
                        </div>
                    </div>
                    {!! CRUDForm::open(['method' => 'POST', 'route' => ['crud.multi-destroy', $ModelName], 'id' => 'delete-multi-form']) !!}
                    <div class="box-body mailbox-messages">

                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th width="20"></th>
                                @foreach ($MasterInstance->getIndexPlanner()->getFields() as $field)
                                    <th>
                                        <a href="{{ route('crud.index', [$ModelName, '_order_by' => $field->getName(), '_order' => Input::get('_order') === 'ASC' ? 'DESC' : 'ASC']) }}">
                                            {{ $field->getLabel() }}
                                            @if (Input::has('_order_by') && Input::get('_order_by') === $field->getName())
                                                <i class="fa fa-sort-{{ Input::get('_order') === 'DESC' ? 'up' : 'down' }}"></i>
                                            @endif
                                        </a>
                                    </th>
                                @endforeach

                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($MasterInstance->getIndexBuilder()->getResult() as $item)
                                <tr>
                                    <td><input type="checkbox" name="delete[{{ $item->getIdentifier() }}]"></td>
                                    @foreach ($item->getFields() as $field)
                                        <td>{!! $field->render() !!}</td>
                                    @endforeach

                                    <td align="right">
                                        <a href="{{ route('crud.edit', [$ModelName, $item->getIdentifier()]) }}"
                                           class="btn btn-xs btn-warning">
                                            <i class="fa fa-edit"></i> {{ trans('crud::index.button.edit') }}
                                        </a>
                                    </td>

                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="box-footer clearfix">
                        <div class="row">
                            <div class="col-sm-6">
                                <a href="{{ route('crud.modal.delete', $ModelName) }}" class="btn btn-danger"
                                   data-toggle="modal" data-target="#field-modal">
                                    <i class="fa fa-trash"></i> {{ trans('crud::index.button.delete-selected', ['model' => $MasterInstance->getModelPluralName()]) }}
                                </a>
                            </div>
                        </div>
                        <div class="col-sm-6 text-right">
                            {{ $MasterInstance->getIndexBuilder()->getPaginator()->render() }}
                        </div>
                    </div>
                    {!! CRUDForm::close() !!}
                </div>
            </div>
        </div>


        <div class="modal fade" id="field-modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close">&times;</button>
                        <h4 class="modal-title">
                            {{ trans('crud::form.modal.loading') }}
                        </h4>
                    </div>
                </div>
            </div>
        </div>

    @endif
@stop