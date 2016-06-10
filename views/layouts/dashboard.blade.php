@extends('crud::master')

@section('content')

    <div class="container-fluid breadcrumb-container">
        <div class="container">
            <ol class="breadcrumb">
                <li class="active"><i class="fa fa-dashboard"></i> {{trans('crud::views.dashboard.title')}}</li>
            </ol>
        </div>
    </div>

    <div class="container">

        @include('crud::partials._session-messages')

    <div class="jumbotron">
        <div class="container-fluid">
            <h1>Welcome to the Admin panel brought to you by <a href="https://github.com/BlackfyreStudio/crud" target="_blank">BlackfyreStudio/CRUD</a>!</h1>
            <p>To change this, edit the published template file under <code>resources/views/vendor/crud/layouts/dashboard.blade.php</code></p>
        </div>
    </div>
    </div>
@stop