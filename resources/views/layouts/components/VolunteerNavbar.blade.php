<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm app-navbar">

    <div class="container-fluid">
        {{-- Sidebar Button --}}
        @if (Auth::guard('web')->check())
            <i class="fas fa-times mr-3 text-left" id="menu-toggle"></i>
        @endif
        {{-- Sidebar Button --}}
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'Laravel') }}
        </a>

        <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarCollapse">
            <!-- Left Side Of Navbar -->
            {{-- <ul class="navbar-nav mr-auto">
            </ul> --}}

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">

                @guest

                {{-- User  --}}
                    @if (Route::is('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif

                    @if (Route::is('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                    @endif
                {{-- User  --}}

                @else
                    <li class="nav-item dropdown">

                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest

            </ul>
        </div>
    </div>
</nav>
