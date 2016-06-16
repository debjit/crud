@extends('crud::master')

@section('content')

<div class="container sceneElement" data-transition="moveleft">
    <div class="row" style="margin-top: 30px">
        <div class="col-sm-8 col-sm-offset-2">

            @include('crud::partials._session-messages')

            {!! CRUDForm::open(['class'=>'form-horizontal']) !!} <!-- Form -->

                <div class="panel panel-default"> <!-- Panel -->
                    <div class="panel-heading">
                        <h3 class="panel-title">Change password</h3>
                    </div>
                    <div class="panel-body">

                        <div class="form-group">
                            {!! CRUDForm::label('original','Original password',['class'=>'col-sm-2 control-label']) !!}
                            <div class="col-sm-10">
                                {!! CRUDForm::password('original',['class'=>'form-control']) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            {!! CRUDForm::label('password','Password',['class'=>'col-sm-2 control-label']) !!}
                            <div class="col-sm-10">
                                {!! CRUDForm::password('password',['class'=>'form-control']) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            {!! CRUDForm::label('password_confirmation','Confirm password',['class'=>'col-sm-2 control-label']) !!}
                            <div class="col-sm-10">
                                {!! CRUDForm::password('password_confirmation',['class'=>'form-control']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <button type="submit" class="btn btn-success">Change</button>
                    </div>
                </div> <!-- /Panel -->

            {!! CRUDForm::close() !!} <!-- /Form -->

        </div>
    </div>
</div>

@endsection