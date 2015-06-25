<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <title>{{Config::get('crud.title.long')}} | Login</title>

    <!-- Bootstrap Core CSS -->
    <link href="{{asset('vendor/blackfyrestudio/crud/styles/crud.css')}}" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="login-page">
<div class="login-box">
    <div class="login-logo">
        {{Config::get('crud.title.long')}}
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Sign in to start your session</p>

        @include('crud::partials._session-messages')

        {!! CRUDForm::open(['route'=>'crud.session-start']) !!}
            <div class="form-group has-feedback">
                <input name="email" type="email" class="form-control" placeholder="{{trans('crud::form.login.email.placeholder')}}"/>
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input name="password" type="password" class="form-control" placeholder="{{trans('crud::form.login.password.placeholder')}}"/>
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-8">
                    <div class="checkbox icheck">
                        <label>
                            <input name="remember" value="1" type="checkbox"> {{trans('crud::form.login.remember-me')}}
                        </label>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">{{trans('crud::form.login.submit.title')}}</button>
                </div>
                <!-- /.col -->
            </div>
        {!! CRUDForm::close() !!}

        <a href="#">{{trans('crud::form.login.forgot-password')}}</a><br>

    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<script src="{{asset('vendor/blackfyrestudio/crud/scripts/crud.js')}}"></script>
</body>
</html>
