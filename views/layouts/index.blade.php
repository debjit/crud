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
                            <p>{{ trans('bauhaus::index.no-filter-results', ['model' => $MasterInstance->getPluralName()]) }}</p>
                            <a class="btn btn-default btn-rounded" href="{{ route('admin.model.index', $name) }}">
                                {{ trans('bauhaus::index.button.reset-filters') }}
                            </a>
                        @else
                            <p>{{ trans('bauhaus::index.no-items-yet', ['model' => $MasterInstance->getPluralName()]) }}</p>
                            <a href="{{ route('admin.model.create', $name) }}" class="btn btn-default btn-red btn-rounded">
                                <i class="fa fa-plus"></i>
                                {{ trans('bauhaus::index.button.create-new', ['model' => $MasterInstance->getSingularName()]) }}
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-sm-{{ $MasterInstance->getFilterBuilder()->getResult()->getFields() ? 8 : 12 }}">
                {{ CRUDForm::open(['method' => 'POST', 'route' => ['crud.multi-destroy', $name], 'id' => 'delete-multi-form']) }}
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th width="20"></th>
                        @foreach ($MasterInstance->getListMapper()->getFields() as $field)
                            <th>
                                <a href="{{ route('admin.model.index', [$name, '_order_by' => $field->getName(), '_order' => Input::get('_order') === 'ASC' ? 'DESC' : 'ASC']) }}">
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
                    @foreach ($MasterInstance->getListBuilder()->getResult() as $item)
                        <tr>
                            <td><input type="checkbox" name="delete[{{ $item->getIdentifier() }}]"></td>
                            @foreach ($item->getFields() as $field)
                                <td>{{ $field->render() }}</td>
                            @endforeach

                            <td align="right">
                                <a href="{{ route('crud.edit', [$name, $item->getIdentifier()]) }}" class="btn btn-xs btn-default">
                                    {{ trans('crud::index.button.edit') }}
                                </a>
                            </td>

                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="{{ count($MasterInstance->getListMapper()->getFields()) + 1 }}">
                            <a href="{{ route('modal.delete', $name) }}" class="btn btn-default btn-rounded" data-toggle="modal" data-target="#field-modal">
                                {{ trans('crud::index.button.delete-selected', ['model' => $MasterInstance->getPluralName()]) }}
                            </a>
                        </td>
                        <td align="right">
                            {{ $MasterInstance->getListBuilder()->getPaginator()->links() }}
                        </td>
                    </tr>
                    </tfoot>
                </table>
                {{ CRUDForm::close() }}
            </div>

            @if ($MasterInstance->getFilterBuilder()->getResult()->getFields())
                @include($MasterInstance->getView('filter'))
            @endif
        </div>
    @endif
@stop