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
        <strong>Copyright &copy; 2015 <a target="_blank" href="{{Config::get('crud.company.link')}}">{{Config::get('crud.company.name')}}</a>.</strong> All rights reserved.
    </footer>
</div><!-- ./wrapper -->

@include('crud::partials._footer')