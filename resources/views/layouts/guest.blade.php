<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('common.head')

<body id="page-top" class="sidebar-toggled">
    <div id="wrapper">

        <!-- content wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- main content -->
            <div id="content">
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown no-arrow">
                            <span class="text-primary">{{ config('app.name') }}</span>
                        </li>
                    </ul>
                </nav>
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