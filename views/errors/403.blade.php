@extends('crud::master-no-control')

@section('subheader')
    <section class="content-header">
        <h1>
            {{trans('crud::error.403.title')}}
            <small>{{trans('crud::error.403.sub-title')}}</small>
        </h1>
        <ol class="breadcrumb">
            <li class="active"><i class="fa fa-dashboard"></i> {{trans('crud::views.dashboard.title')}}</li>
        </ol>
    </section>
@stop

@section('content')
    <div class="jumbotron">
        <div class="container-fluid">
            <h1>{{trans('crud::error.403.message.main')}}</h1>
            <p>{{trans('crud::error.403.message.logged')}}</p>
        </div>
    </div>
@stop