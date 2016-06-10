@extends('crud::master')


@section('content')

    <div class="container-fluid breadcrumb-container">
        <div class="container">
            <ol class="breadcrumb">
                <li><a href="{{URL::route('crud.home')}}"><i
                                class="fa fa-dashboard"></i> {{trans('crud::views.dashboard.title')}}</a></li>
                <li class="active">{{ trans('crud::index.list-title', ['model' => $MasterInstance->getModelPluralName()]) }}</li>
            </ol>
        </div>
    </div>

    <div class="container">

        @include('crud::partials._session-messages')


        @if (count($MasterInstance->getIndexBuilder()->getResult()) === 0)

            {{-- No content --}}

            @include('crud::partials._session-messages')

            <div class="row">
                <div class="col-sm-4 col-sm-offset-4">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h1 class="panel-title">{{$MasterInstance->getModelPluralName()}}</h1>
                        </div>
                        <div class="panel-body text-center">
                            @if (Input::has('_filtering'))
                                <p>{{ trans('crud::index.no-filter-results', ['model' => $MasterInstance->getModelPluralName()]) }}</p>
                                <a class="btn btn-default" href="{{ route('crud.index', $ModelName) }}">
                                    {{ trans('crud::index.button.reset-filters') }}
                                </a>
                            @else
                                <p>{{ trans('crud::index.no-items-yet', ['model' => $MasterInstance->getModelPluralName()]) }}</p>
                                <a href="{{ route('crud.create', $ModelName) }}"
                                   class="btn btn-success">
                                    <i class="fa fa-plus"></i>
                                    {{ trans('crud::index.button.create-new', ['model' => $MasterInstance->getModelSingularName()]) }}
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>


            @else

            {{-- Has content --}}
            <div class="row">
                <div class="col-sm-{{ $MasterInstance->getFilterBuilder()->getResult()->getFields() ? 9 : 12 }}">

                    <div class="row index-title">
                        <div class="col-sm-6">
                            <h2>{{ trans('crud::index.list-title', ['model' => $MasterInstance->getModelPluralName()]) }}</h2>
                        </div>
                        <div class="col-sm-6">
                            <div class="btn-group btn-group-sm pull-right" role="group" aria-label="...">

                                {{-- Create Model button --}}
                                @if(\Auth::user()->hasPermission($ModelName . '.create'))
                                <a class="btn btn-success" href="{{ route('crud.create', $ModelName) }}">
                                    <i class="fa fa-fw fa-plus"></i>
                                    {{ trans('crud::index.button.create-new', ['model' => $MasterInstance->getModelSingularName()]) }}
                                </a>
                                @endif

                                {{-- Export button --}}

                                @if(count($MasterInstance->getExportTypes()) > 0)

                                <div class="btn-group btn-group-sm" role="group">
                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                        Export
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        @foreach ($MasterInstance->getExportTypes() as $exportType)
                                            <li>
                                                <a href="{{ route('crud.export', [$ModelName, $exportType]) }}">{{ $exportType }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    @include('crud::partials._session-messages')

                    @if (Input::has('_filtering'))
                        <div class="alert alert-warning">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <strong>{{ trans('crud::messages.warning.title') }}</strong>
                            {{ trans('crud::index.browsing-filtered') }}
                        </div>
                    @endif

                    {!! CRUDForm::open(['method' => 'POST', 'route' => ['crud.multi-destroy', $ModelName], 'id' => 'delete-multi-form']) !!}

                    <div class="table-responsive">

                        <table class="table table-hover table-condensed">
                            <thead>
                            <tr>

                                @if(\Auth::user()->hasPermission($ModelName . '.delete'))
                                <th></th>
                                @endif

                                @foreach ($MasterInstance->getIndexPlanner()->getFields() as $field)
                                    <th {{$field->renderContainerAttributes()}}>
                                        <a href="{{ route('crud.index', [$ModelName, '_order_by' => $field->getName(), '_order' => Input::get('_order') === 'ASC' ? 'DESC' : 'ASC']) }}">
                                            {{ $field->getLabel() }}
                                            @if (Input::has('_order_by') && Input::get('_order_by') === $field->getName())
                                                <i class="fa fa-sort-{{ Input::get('_order') === 'DESC' ? 'up' : 'down' }}"></i>
                                            @endif
                                        </a>
                                    </th>
                                @endforeach

                                @if(\Auth::user()->hasPermission($ModelName . '.edit'))
                                <th></th>
                                @endif

                            </tr>
                            </thead>

                            <tbody>

                            @foreach ($MasterInstance->getIndexBuilder()->getResult() as $item)
                                <tr>

                                    @if(\Auth::user()->hasPermission($ModelName . '.delete'))
                                        <td>
                                            <label>
                                                <input type="checkbox"  class="deleter" name="delete[{{ $item->getIdentifier() }}]">
                                            </label>
                                        </td>
                                    @endif

                                    @foreach ($item->getFields() as $field)
                                        <td {{$field->renderContainerAttributes()}}>{!! $field->render() !!}</td>
                                    @endforeach

                                    @if(\Auth::user()->hasPermission($ModelName . '.edit'))
                                        <td align="right">
                                            <a href="{{ route('crud.edit', [$ModelName, $item->getIdentifier()]) }}"
                                               class="btn btn-xs btn-warning">
                                                <i class="fa fa-fw fa-edit"></i> {{ trans('crud::index.button.edit') }}
                                            </a>
                                        </td>
                                    @endif

                                </tr>
                            @endforeach

                            </tbody>

                            <tfoot>
                            <tr>

                                @if(\Auth::user()->hasPermission($ModelName . '.delete'))
                                    <th></th>
                                @endif

                                @foreach ($MasterInstance->getIndexPlanner()->getFields() as $field)
                                    <th {{$field->renderContainerAttributes()}}>
                                        <a href="{{ route('crud.index', [$ModelName, '_order_by' => $field->getName(), '_order' => Input::get('_order') === 'ASC' ? 'DESC' : 'ASC']) }}">
                                            {{ $field->getLabel() }}
                                            @if (Input::has('_order_by') && Input::get('_order_by') === $field->getName())
                                                <i class="fa fa-sort-{{ Input::get('_order') === 'DESC' ? 'up' : 'down' }}"></i>
                                            @endif
                                        </a>
                                    </th>
                                @endforeach

                                @if(\Auth::user()->hasPermission($ModelName . '.edit'))
                                    <th></th>
                                @endif

                            </tr>
                            </tfoot>

                        </table>

                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            @if(\Auth::user()->hasPermission($ModelName . '.delete'))
                            <a href="{{ route('crud.modal.delete', $ModelName) }}" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Deleting..."
                                    class="btn btn-danger btn-sm btn-deleter" disabled><i class="fa fa-fw fa-trash"></i>
                                {{ trans('crud::index.button.delete-selected', ['model' => $MasterInstance->getModelPluralName()]) }}
                            </a>
                            @endif
                        </div>
                        <div class="col-sm-6">

                            @include('crud::partials._paginator', ['paginator' => $MasterInstance->getIndexBuilder()->getPaginator()])

                        </div>
                    </div>

                    {!! CRUDForm::close() !!}
                </div>

                {{-- Filter --}}

                @if($MasterInstance->getFilterBuilder()->getResult()->getFields())
                    <div class="col-sm-3">
                        <div class="well well-sm">
                            <form>
                                <fieldset>
                                    <legend><i class="fa fa-fw fa-filter"></i> Filters</legend>
                                </fieldset>

                                <div class="form-group">
                                    <label for="filter-content">Content</label>
                                    <input class="form-control input-sm" type="text" id="filter-content">
                                </div>

                                <div class="form-group">
                                    <label for="updated-at-from">Updated at between</label>
                                    <div class="input-group">
                    <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                                        <input class="form-control" type="text" data-format="YYYY-MM-DD" data-provide="date-range"
                                               data-range="start" data-counterpart="#updated-at-to" id="updated-at-from">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="updated-at-to">and</label>
                                    <div class="input-group">
                    <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                                        <input class="form-control" type="text" data-format="YYYY-MM-DD" data-provide="date-range"
                                               data-range="end" data-counterpart="#updated-at-from" id="updated-at-to">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-sm">Apply</button>
                                </div>

                            </form>

                        </div>
                    </div>
                @endif


            </div>


        @endif

    </div>

@stop