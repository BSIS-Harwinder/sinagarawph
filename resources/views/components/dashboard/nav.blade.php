@if(Auth::guard('client')->check())
    <div class="navbar-custom">
        <ul class="list-unstyled topnav-menu float-right mb-0">
            <li class="dropdown notification-list">
                <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                    <img src="{{ asset('images/users/default.png') }}" alt="dpic" class="rounded-circle">
                    <span class="pro-user-name ml-1">
                    {{ Auth::user()->first_name }} {{ Auth::user()->last_name }} <i class="mdi mdi-chevron-down"></i>
                </span>
                </a>
                <div class="dropdown-menu dropdown-menu-right profile-dropdown">
                    <a href="#" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Sign Out
                    </a>

                    <form id="logout-form" action="{{ route('client.logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>
        </ul>

        <!-- LOGO -->
        <div class="logo-box">
            <a href="{{ route('client.login') }}" class="logo text-center">
            <span class="logo-lg">
                <img src="{{ asset('images/logo-dark-white.png') }}" alt="" height="70">
            </span>
                <span class="logo-sm">
                <img src="{{ asset('images/logo-dark-white.png') }}" alt="" height="24">
            </span>
            </a>
        </div>

        <ul class="list-unstyled topnav-menu topnav-menu-left m-0">
            <li>
                <button class="button-menu-mobile waves-effect waves-light">
                    <i class="fe-menu"></i>
                </button>
            </li>
        </ul>
    </div>
@else
    <div class="navbar-custom">
        <ul class="list-unstyled topnav-menu float-right mb-0">
            <li class="dropdown notification-list">
                <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                    <img src="{{ asset('images/users/default.png') }}" alt="dpic" class="rounded-circle">
                    <span class="pro-user-name ml-1">
                    {{ Auth::user()->first_name }} {{ Auth::user()->last_name }} <i class="mdi mdi-chevron-down"></i>
                </span>
                </a>
                <div class="dropdown-menu dropdown-menu-right profile-dropdown">
                    <a href="#" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Sign Out
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>
        </ul>

        <!-- LOGO -->
        <div class="logo-box">
            <a href="{{ route('login') }}" class="logo text-center">
            <span class="logo-lg">
                <img src="{{ asset('images/logo-dark-white.png') }}" alt="" height="70">
            </span>
                <span class="logo-sm">
                <img src="{{ asset('images/logo-dark-white.png') }}" alt="" height="24">
            </span>
            </a>
        </div>

        <ul class="list-unstyled topnav-menu topnav-menu-left m-0">
            <li>
                <button class="button-menu-mobile waves-effect waves-light">
                    <i class="fe-menu"></i>
                </button>
            </li>
        </ul>
    </div>
@endif
