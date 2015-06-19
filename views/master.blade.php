<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>{{Config::get('crud.title')}}</title>

    <!-- Bootstrap Core CSS -->
    <link href="{{asset('vendor/blackfyrestudio/crud/styles/sb-admin-2.min.css')}}" rel="stylesheet">

    @foreach (Config::get('crud.assets.stylesheets') as $stylesheet)
        <link rel="stylesheet" href="{{ asset($stylesheet) }}">
    @endforeach

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

<div id="wrapper">

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{URL::route('crud.home')}}">{{Config::get('crud.title')}}</a>
        </div>
        <!-- /.navbar-header -->

        <ul class="nav navbar-top-links navbar-right">
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                    </li>
                    <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                    </li>
                    <li class="divider"></li>
                    <li><a href="login.html"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                    </li>
                </ul>
                <!-- /.dropdown-user -->
            </li>
            <!-- /.dropdown -->
        </ul>
        <!-- /.navbar-top-links -->

        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                {!! BlackfyreStudio\CRUD\Builders\MenuBuilder::build() !!}
            </div>
            <!-- /.sidebar-collapse -->
        </div>
        <!-- /.navbar-static-side -->
    </nav>

    <div id="page-wrapper">
        @yield('subheader')
        <div class="row">
            <div class="col-xs-12">
                @include('crud::partials._session-messages')
            </div>
        </div>
        <div class="row">
            <div class="col-sm-2">
                @yield('sidebar')
            </div>
            <div class="col-sm-8">
                @yield('content')
            </div>
            <div class="col-sm-2"></div>
        </div>

    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<script src="{{asset('vendor/blackfyrestudio/crud/scripts/admin.min.js')}}"></script>

@foreach (Config::get('crud.assets.javascript') as $javascript)
    <script src="{{ asset($javascript) }}"></script>
@endforeach

</body>

</html>
