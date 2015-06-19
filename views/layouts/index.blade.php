@extends('crud::master')

@section('subheader')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">{{$ModelName}} Index</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
@stop

@section('sidebar')
    <ul class="nav nav-sidebar">
        <li>
            <a href="{{ route('crud.index', $ModelName) }}">
                <i class="fa fa-bars"></i>
                {{ trans('crud::index.button.overview') }}
            </a>
        </li>
        <li>
            <a href="{{ route('crud.create', $ModelName) }}">
                <i class="fa fa-plus"></i>
                {{ trans('crud::index.button.create-new', ['model' => $MasterInstance->getModelSingularName()]) }}
            </a>
        </li>
    </ul>

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
    @endif

    <ul class="nav nav-sidebar nav-bottom">
        <li>
            <div class="btn-group dropup">
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-share-square-o"></i>
                    {{ trans('crud::index.sidebar.export') }}
                </button>
                <ul class="dropdown-menu" role="menu">
                    @foreach ($MasterInstance->getExportTypes() as $exportType)
                        <li>
                            <a href="{{ route('crud.export', [$ModelName, $exportType]) }}">{{ $exportType }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </li>
    </ul>
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
                            <p>{{ trans('crud::index.no-filter-results', ['model' => $MasterInstance->getPluralName()]) }}</p>
                            <a class="btn btn-default btn-rounded" href="{{ route('crud.index', $ModelName) }}">
                                {{ trans('crud::index.button.reset-filters') }}
                            </a>
                        @else
                            <p>{{ trans('crud::index.no-items-yet', ['model' => $MasterInstance->getPluralName()]) }}</p>
                            <a href="{{ route('crud.create', $ModelName) }}" class="btn btn-default btn-red btn-rounded">
                                <i class="fa fa-plus"></i>
                                {{ trans('crud::index.button.create-new', ['model' => $MasterInstance->getSingularName()]) }}
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-sm-{{ $MasterInstance->getFilterBuilder()->getResult()->getFields() ? 8 : 12 }}">
                {!! CRUDForm::open(['method' => 'POST', 'route' => ['crud.multi-destroy', $ModelName], 'id' => 'delete-multi-form']) !!}
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
                                <a href="{{ route('crud.edit', [$ModelName, $item->getIdentifier()]) }}" class="btn btn-xs btn-default">
                                    {{ trans('crud::index.button.edit') }}
                                </a>
                            </td>

                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="{{ count($MasterInstance->getIndexPlanner()->getFields()) + 1 }}">
                            <a href="{{ route('crud.modal.delete', $ModelName) }}" class="btn btn-default btn-rounded" data-toggle="modal" data-target="#field-modal">
                                {{ trans('crud::index.button.delete-selected', ['model' => $MasterInstance->getModelPluralName()]) }}
                            </a>
                        </td>
                        <td align="right">
                            {{ $MasterInstance->getIndexBuilder()->getPaginator()->render() }}
                        </td>
                    </tr>
                    </tfoot>
                </table>
                {!! CRUDForm::close() !!}
            </div>

            @if ($MasterInstance->getFilterBuilder()->getResult()->getFields())
                @include($MasterInstance->getView('filter'))
            @endif
        </div>
    @endif
@stop