<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('common.head')

<body id="page-top">
    @include('common.header')
    <div id="wrapper">
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <div class="container">
                    @yield('content')
                </div>
            </div>
            @include('common.footer')
        </div>
    </div>
    <button type="button" class="btn btn-info btn-floating btn-back-to-top" id="btn-back-to-top">
        <i class="fas fa-arrow-up"></i>
    </button>
    @include('common.script')
</body>

</html>
