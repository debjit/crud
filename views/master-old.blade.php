@include('crud::partials._header')

<div class="wrapper">

    @include('crud::partials._nav')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        @yield('subheader')

        <!-- Main content -->
        <section class="content">

            <!-- Session notifications -->
            <div class="row">
                <div class="col-xs-12">
                    @include('crud::partials._session-messages')
                </div>
            </div>

            <!-- Page Content -->
            @yield('content')

        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->

    <!-- Main Footer -->
    <footer class="main-footer">
        <!-- Default to the left -->
        <strong>Copyright &copy; {{Config::get('crud.company.year',date('Y'))}} <a target="_blank" href="{{Config::get('crud.company.link','https://github.com/BlackfyreStudio')}}">{{Config::get('crud.company.name','BlackFyre Studio')}}</a>.</strong> All rights reserved.
    </footer>

    @if(Config::get('crud.right-menu',false))


    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Create the tabs -->
        <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
            <li class="active"><a href="#control-sidebar-filter-tab" data-toggle="tab"><i class="fa fa-filter"></i></a></li>
            <li><a href="#control-sidebar-scopes-tab" data-toggle="tab"><i class="fa fa-crosshairs"></i></a></li>
            <li><a href="#control-sidebar-export-tab" data-toggle="tab"><i class="fa fa-download"></i></a></li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
            <!-- Home tab content -->
            <div class="tab-pane active" id="control-sidebar-filter-tab">
                <h3 class="control-sidebar-heading">Filters</h3>
                @yield('filters')
                <a href="#" class="btn btn-info btn-block" data-toggle="control-sidebar">Close</a>
            </div><!-- /.tab-pane -->
            <!-- Settings tab content -->
            <div class="tab-pane" id="control-sidebar-scopes-tab">
                <h3 class="control-sidebar-heading">Scopes</h3>
                @yield('scopes')
                <a href="#" class="btn btn-info btn-block" data-toggle="control-sidebar">Close</a>
            </div><!-- /.tab-pane -->
            <div class="tab-pane" id="control-sidebar-export-tab">
                <h3 class="control-sidebar-heading">Export</h3>
                @yield('export')
                <a href="#" class="btn btn-info btn-block" data-toggle="control-sidebar">Close</a>
            </div><!-- /.tab-pane -->
        </div>
    </aside><!-- /.control-sidebar -->
    <!-- Add the sidebar's background. This div must be placed
         immediately after the control sidebar -->
    <div class='control-sidebar-bg'></div>
    @endif
</div><!-- ./wrapper -->

@include('crud::partials._footer')

