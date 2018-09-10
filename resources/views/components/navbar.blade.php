<nav class="navbar navbar-expand-md fixed-top navbar-dark bg-primary shadow-lg p-3 mb-5">

        <a class="navbar-brand" href="{{ url('/') }}">{{ config('app.name') }}</a>
        <button class="navbar-toggler p-0 border-0" type="button" data-toggle="offcanvas">
            <span class="navbar-toggler-icon"></span>
        </button>
    
        <div class="navbar-collapse offcanvas-collapse bg-primary" id="navbarsExampleDefault">
    
            <ul class="navbar-nav mr-auto">
                <li class="nav-item {{ Request::is('dashboard') ? 'active' : ''}}">
                    <a href="{{ route('dashboard') }}" class="nav-link">Dashboard</a>
                </li>
                {{-- <li class="nav-item {{ Request::is('dashboard/performance-evaluation') ? 'active' : ''}}">
                    <a href="#" class="nav-link">Performance Evaluation</a>
                </li> --}}
            </ul>
    
            <ul class="navbar-nav ml-auto">   
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        <img src="{{ asset('storage/images/') }}/{{ auth()->user()->profile->avatar }}" alt="" width="20" height="20">
                        {{ auth()->user()->name }} 
                        <span class="caret"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('manager.profile') }}">
                            <span class="fa fa-user"></span> {{ __('My Profile') }}
                        </a>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                            <span class="fa fa-sign-out"></span> {{ __('Logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>
        </div>
    </nav>