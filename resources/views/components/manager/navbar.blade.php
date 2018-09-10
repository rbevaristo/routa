<nav class="navbar navbar-expand-md fixed-top navbar-dark bg-primary shadow-lg p-3 mb-5">

    <a class="navbar-brand" href="{{ url('/') }}">{{ config('app.name') }}</a>
    <button class="navbar-toggler p-0 border-0" type="button" data-toggle="offcanvas">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="navbar-collapse offcanvas-collapse bg-primary" id="navbarsExampleDefault">

        <ul class="navbar-nav mr-auto">
            <li class="nav-item {{ Request::is('manager/dashboard') ? 'active' : ''}}">
                <a href="{{ route('manager.dashboard') }}" class="nav-link">Dashboard</a>
            </li>
            <li class="nav-item {{ Request::is('manager/dashboard/messages') ? 'active' : ''}}">
                <a href="{{ route('manager.messages') }}" class="nav-link">Inbox</a>
            </li>
            <li class="nav-item {{ Request::is('manager/dashboard/performance') ? 'active' : ''}}">
                <a href="{{ route('manager.performance') }}" class="nav-link">Performance Evaluation</a>
            </li>
        </ul>

        <ul class="navbar-nav ml-auto">
                @if(Auth::check())
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        <span class="fa fa-bell text-white"></span>

                        @if(auth()->user()->unreadNotifications->count())

                            <span class="badge badge-danger">
                                {{auth()->user()->unreadNotifications->count()}}
                            </span>

                        @endif

                        <span class="d-sm-block d-md-none"> Notifications</span>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-right notifications" aria-labelledby="navbarDropdown">
                        <div class="notification-heading">
                            <small class="menu-title">Notifications</small>
                        </div>
                        <li class="divider"></li>
                        <div class="notifications-wrapper">

                            @if(auth()->user()->unreadNotifications->count())

                                @foreach(auth()->user()->unreadNotifications as $notification)

                                    <a class="content" href="{{route('user.message.read', [
                                        'notification_id' => $notification->id,
                                        'message_id' => $notification->data["messages"]["id"],
                                    ])}}">
                                        <div class="notification-item">
                                            <div class="media">
                                                <div class="media-left">
                                                    <img src="{{ asset('storage/images/') }}/{{ \App\Employee::where('id',$notification->data["messages"]["emp_id"])->first()->profile->avatar }}" class="media-object rounded" style="width:60px">
                                                </div>
                                                <div class="media-body">
                                                    <p class="media-heading"> 
                                                        {{ \App\Employee::where('id',$notification->data["messages"]["emp_id"])->first()->firstname }}
                                                        {{ \App\Employee::where('id',$notification->data["messages"]["emp_id"])->first()->lastname }} <br>
                                                        {{ $notification->data["messages"]["title"] }} 
                                                        <span class="float-right">
                                                            <small>{{ date('F d, Y', strtotime($notification->created_at))}}</small> 
                                                        </span>
                                                    </p>
    
                                                </div>
                                            </div>
                                        </div>   
                                    </a>

                                @endforeach

                            @else

                                <a class="content" href="#">
                                    <div class="notification-item">
                                        No Message
                                    </div>   
                                </a>

                            @endif

                        </div>
                        <li class="divider"></li>
                        <div class="notification-footer text-center">
                            <a href="#"><small class="menu-title">View all</small></a>
                        </div>
                    </ul>
                </li>

            @endif
            <li class="nav-item dropdown">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    <img src="{{ asset('storage/images/') }}/{{ auth()->user()->profile->avatar }}" alt="" width="20" height="20">
                    {{ Helper::name() }} 
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