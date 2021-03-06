<nav class="navbar navbar-expand-md fixed-top navbar-dark bg-primary shadow-lg p-3 mb-5">
    <a class="navbar-brand" href="{{ url('/') }}"><img src="{{ asset('img/logo.png') }}" alt="logo" width="40" height="40"> {{ config('app.name') }}</a>
    <button class="navbar-toggler p-0 border-0" type="button" data-toggle="offcanvas">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="navbar-collapse offcanvas-collapse bg-primary" id="navbarsExampleDefault">
        <!-- Left Side Of Navbar -->
        <ul class="navbar-nav mr-auto">

        </ul>

        <!-- Right Side Of Navbar -->
        <ul class="navbar-nav ml-auto">
            <!-- Page Links-->
            <li class="nav-item {{ Request::is('/#home') ? 'active' : ''}}">
                <a href="{{ Request::is('login') || Request::is('register') || Request::is('login/admin') || Request::is('employee/password/reset') || Request::is('password/reset') ? url('/') : '#home' }}" class="nav-link">Home</a>
            </li>
            <li class="nav-item {{ Request::is('/#about') ? 'active' : ''}}">
                <a href="{{ Request::is('login') || Request::is('register') || Request::is('login/admin') || Request::is('employee/password/reset') || Request::is('password/reset') ? url('/#about') : '#about' }}" class="nav-link">About</a>
            </li>
            <li class="nav-item {{ Request::is('/#services') ? 'active' : '' }}">
                <a href="{{ Request::is('login') || Request::is('register') || Request::is('login/admin') || Request::is('employee/password/reset') || Request::is('password/reset') ? url('/#services') : '#services' }}" class="nav-link">Services</a>
            </li>
            <li class="nav-item {{ Request::is('/#team') ? 'active' : ''}}">
                <a href="{{ Request::is('login') || Request::is('register') || Request::is('login/admin') || Request::is('employee/password/reset') || Request::is('password/reset') ? url('/#team') : '#team' }}" class="nav-link">Team</a>
            </li>
            <li class="nav-item {{ Request::is('/#contact') ? 'active' : ''}}">
                <a href="{{ Request::is('login') || Request::is('register') || Request::is('login/admin') || Request::is('employee/password/reset') || Request::is('password/reset') ? url('/#contact') : '#contact' }}" class="nav-link">Contact</a>
            </li>
            @if(auth()->guard() && auth()->guard()->user())
            <li class="nav-item dropdown">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    <img src="{{ asset('storage/images/') }}/{{ auth()->user()->profile->avatar }}" alt="" width="20" height="20">
                    {{ auth()->guard()->user()->name }} 
                    <span class="caret"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ route('dashboard') }}">
                        Dashboard
                    </a>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>
            @elseif(auth()->guard('manager') && auth()->guard('manager')->user())
            <li class="nav-item dropdown">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    <img src="{{ asset('storage/images/') }}/{{ auth()->guard('manager')->user()->profile->avatar }}" alt="" width="20" height="20">
                    {{ auth()->guard('manager')->user()->firstname }} {{ auth()->guard('manager')->user()->lastname }} 
                    <span class="caret"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ route('manager.dashboard') }}">
                        Dashboard
                    </a>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>
            @elseif(auth()->guard('employee') && auth()->guard('employee')->user())
            <li class="nav-item dropdown">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    <img src="{{ asset('storage/images/') }}/{{ auth()->guard('employee')->user()->profile->avatar }}" alt="" width="20" height="20">
                    {{ auth()->guard('employee')->user()->firstname }} {{ auth()->guard('employee')->user()->lastname }} 
                    <span class="caret"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ route('employee.dashboard') }}">
                        Dashboard
                    </a>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>
            @else
            <li class="nav-item {{ Request::is('login') ? 'active' : ''}}">
                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
            </li>
            <li class="nav-item {{ Request::is('register') ? 'active' : ''}}">
                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
            </li>
            @endif
        </ul>
    </div>
</nav>