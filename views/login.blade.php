<!doctype html>
<html class="no-js" lang="">
<head>
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{Config::get('crud.title')}}</title>

    <link rel="apple-touch-icon" href="apple-touch-icon.png">
    <!-- Place favicon.ico in the root directory -->

    <link href="{{asset('vendor/blackfyrestudio/crud/styles/login.css')}}" rel="stylesheet">

</head>
<body>
<!--[if lt IE 10]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->

<div class="container">
    <div class="row">
        <div class="col-sm-6 col-md-4 col-md-offset-4">
            <h1 class="text-center login-title">Sign in to continue</h1>
            <div class="account-wall">
                <img class="profile-img" src="https://lh5.googleusercontent.com/-b0-k99FZlyE/AAAAAAAAAAI/AAAAAAAAAAA/eu7opA4byxI/photo.jpg?sz=120"
                     alt="">
                @include('crud::partials._session-messages')

                {!! CRUDForm::open(['route'=>'crud.session-start','class'=>'form-signin']) !!}


                {!! CRUDForm::email('email',null,['class'=>'form-control','required','autofocus','placeholder'=>'Email','id'=>'email']) !!}
                {!! CRUDForm::password('password',['class'=>'form-control','required','placeholder'=>'Password']) !!}

                {!! CRUDForm::submit('Sign in',['class'=>'btn btn-lg btn-primary btn-block']) !!}


                <div class="checkbox pull-left">
                    <label class="">
                {!! CRUDForm::checkbox('remember') !!} Remember me
                    </label>
                </div>

                <span class="clearfix"></span>


                {{--
                    <a title="Forgot your password?" href="#" class="pull-right need-help">Need help? </a><span class="clearfix"></span>
                --}}
                {!! CRUDForm::close() !!}

            </div>
        </div>
    </div>
</div>

<script src="{{asset('vendor/blackfyrestudio/crud/scripts/login.js')}}"></script>

</body>
</html>
