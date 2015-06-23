@extends('crud::master-no-control')

@section('subheader')
    <section class="content-header">
        <h1>
            {{trans('crud::views.dashboard.title')}}
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li class="active"><i class="fa fa-dashboard"></i> {{trans('crud::views.dashboard.title')}}</li>
        </ol>
    </section>
@stop

@section('content')
    <div class="jumbotron">
        <div class="container-fluid">
            <h1>Welcome to the BlackfyreStudio/CRUD admin generator!</h1>
            <p>To change this, edit the published template file under <code>resources/views/vendor/crud/layouts/dashboard.blade.php</code></p>
        </div>
    </div>
@stop