<header>
    <nav class="navbar navbar-light bg-white topbar mb-4 static-top shadow">
        <div class="d-flex align-items-center">
            @if (!Auth::guest())
                <button class="navbar-toggler btn btn-link rounded-circle mr-2 px-2" type="button" data-toggle="collapse"
                    data-target="#navbar" aria-controls="nabvar" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand" href="{{ route('home') }}">{{ config('app.name') }}</a>
            @else
                <a class="navbar-brand" href="#">{{ config('app.name') }}</a>
            @endif
        </div>

        @if (!Auth::guest())
            <div class="collapse navbar-collapse border-top" id="navbar">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">
                            <i class="fas fa-home fa-fw mr-2"></i>
                            {{ __('home') }}
                        </a>
                    </li>
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
                    <li class="nav-item border-top my-0"></li>
                    <li class="nav-item">
                        <span class="nav-link">
                            <i class="fas fa-user fa-fw mr-2"></i>
                            {{ Auth::user()->name }}
                        </span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link ml-4" href="{{ route('change_password') }}">
                            <i class="fas fa-cogs fa-fw mr-2"></i>
                            {{ __('change_password') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link ml-4" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt fa-fw mr-2"></i>
                            {{ __('logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        @endif
    </nav>
</header>
