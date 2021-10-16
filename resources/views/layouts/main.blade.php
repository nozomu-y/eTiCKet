<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('common.head')

<body id="page-top" class="sidebar-toggled">
    <div id="wrapper">
        @include('common.sidebar')

        <!-- content wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- main content -->
            <div id="content">
                @include('common.header')
                @yield('content')
            </div>

            @include('common.footer')

        </div>
    </div>
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    @include('common.script')

</body>

</html>
