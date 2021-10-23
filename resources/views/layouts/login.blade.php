<!DOCTYPE html>
<html lang="ja">

@include('common.head')

<body class="bg-gradient-primary">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-9">
                @yield('content')
            </div>
        </div>
    </div>

    @include('common.script')

</body>

</html>
