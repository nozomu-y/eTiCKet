<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion toggled" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('home')}}">
        <div class="sidebar-brand-icon">
            <i class="fas fa-music"></i>
        </div>
        <div class="sidebar-brand-text mx-3" style="text-transform: none;">{{ config('app.name') }}</div>
    </a>
    <hr class="sidebar-divider my-0">
    <!-- nav item -->
    <li class="nav-item">
        <a class="nav-link" href="{{route('home')}}">
            <i class="fas fa-home fa-fw"></i>
            <span>Home</span>
        </a>
    </li>
    @if (Auth::user()->role == 'admin')
    <hr class="sidebar-divider my-0">
    <li class="nav-item">
        <a class="nav-link" href="">
            <i class="fas fa-users fa-fw"></i>
            <span>アカウント一覧</span>
        </a>
    </li>
    @endif
    <hr class="sidebar-divider my-0">
    <li class="nav-item">
        <a class="nav-link" href="">
            <i class="fas fa-qrcode fa-fw"></i>
            <span>電子チケット</span>
        </a>
    </li>
    <hr class="sidebar-divider my-0">
    <li class="nav-item">
        <a class="nav-link" href="">
            <i class="fas fa-info-circle fa-fw"></i>
            <span>Info</span>
        </a>
    </li>
    <hr class="sidebar-divider d-none d-md-block">
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" onclick="sidebarToggle();" id="sidebarToggle"></button>
    </div>
</ul>

<script>
    function sidebarToggle() {
        if (document.getElementById('accordionSidebar').classList.contains('toggled')) {
            document.cookie = 'MypageSidebarToggle=;path={{env('APP_URL')}}';
        } else {
            document.cookie = 'MypageSidebarToggle=toggled;path={{env('APP_URL')}}';
        }
    }
    for (var c of document.cookie.split(";")) {
        var cArray = c.split('=');
        if (cArray[0] == 'MypageSidebarToggle') {
            if (cArray[1] == 'toggled') {
                document.getElementById('accordionSidebar').classList.add('toggled');
            } else {
                document.getElementById('accordionSidebar').classList.remove('toggled');
            }
        }
    }
</script>
