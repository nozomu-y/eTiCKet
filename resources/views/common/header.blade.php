<header>
    <nav class="navbar navbar-light bg-white topbar mb-4 static-top shadow">
        <div class="d-flex align-items-center">
            @if (!Auth::guest())
                <button class="navbar-toggler btn btn-link rounded-circle mr-2 px-2" type="button" data-toggle="collapse"
                    data-target="#navbar" aria-controls="nabvar" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa fa-bars"></i>
                </button>
            @endif
            <a class="navbar-brand" href="{{ route('home') }}">{{ config('app.name') }}</a>
        </div>

        @if (!Auth::guest())
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown no-arrow">
                    <a class="nav-link" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-user fa-fw"></i>
                        <span class="mr-2 text-gray-600 small">{{ Auth::user()->name }}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                        aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="{{ route('change_password') }}">
                            <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                            {{ __('change_password') }}
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                            {{ __('logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>

            <div class="collapse navbar-collapse" id="navbar">
                <ul class="navbar-nav">
                    @if (Auth::user()->role == 'admin')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('accounts') }}">
                                <i class="fas fa-users fa-fw mr-2"></i>
                                {{ __('accounts_list') }}
                            </a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('events') }}">
                            <i class="fas fa-qrcode fa-fw mr-2"></i>
                            {{ __('electronic_tickets') }}
                        </a>
                    </li>
                    {{-- <li class="nav-item"> --}}
                    {{-- <a class="nav-link" href=""> --}}
                    {{-- <i class="fas fa-info-circle fa-fw mr-2"></i> --}}
                    {{-- {{ __('info') }} --}}
                    {{-- </a> --}}
                    {{-- </li> --}}
                </ul>
            </div>
        @endif
    </nav>
</header>
