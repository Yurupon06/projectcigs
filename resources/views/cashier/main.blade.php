<main class="main-content position-relative max-height-vh-100 h-100 ">
    <style>
        body {
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        .navbar-main {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            width: 100%;
            z-index: 1030;
        }

        .navbar-main .container-fluid {
            max-width: 100%;
            padding-left: 1rem;
            padding-right: 1rem;
        }
    </style>
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0shadow-none" id="navbarBlur" data-scroll="true"
        style="background-color: #080808">
        <img src="{{ isset($setting) && $setting->app_logo ? asset('storage/' . $setting->app_logo) : asset('assets/images/logo_gym.png') }}"
            alt="logo" width="50px" height="50px" class="ms-4">
        <div class="container-fluid py-1 px-3">
            <nav aria-label="breadcrumb">
                <h6 class="font-weight-bolder mb-0 text-white">@yield('page-title')</h6>
            </nav>
            <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
                <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                </div>
                <ul class="navbar-nav  justify-content-end">
                    @auth
                        <li class="nav-item d-flex align-items-center">
                            <a href="{{ route('cashier.profile') }}" class="nav-link text-white font-weight-bold px-0">
                                <span class="text-capitalize profile {{ request()->routeIs('cashier.profile') ? 'active' : '' }}">
                                    {{ Auth::user()->role }} - {{ Auth::user()->name }}
                                </span>
                                <style>
                                    .profile.active{
                                        color: #ff8800
                                    }
                                    .profile:hover {
                                        color: #ff8800
                                    }
                                </style>
                            </a>
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                class="nav-link text-white font-weight-bold px-0 ms-4">
                                <div class="sign-out">
                                    <i class="fa fa-sign-out me-1"></i>
                                    <span class="d-sm-inline d-none">Sign Out</span>
                                </div>
                                <style>
                                    .sign-out:hover {
                                        color: #D81B60;
                                    }
                                </style>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    @else
                        <li class="nav-item d-flex align-items-center">
                            <a href="{{ route('login') }}" class="nav-link text-body font-weight-bold px-0">
                                <i class="fa fa-user me-sm-1"></i>
                                <span class="d-sm-inline d-none">Sign In</span>
                            </a>
                        </li>
                    @endauth
                </ul>
                <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                        <div class="sidenav-toggler-inner">
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                        </div>
                    </a>
                </li>
            </div>
        </div>
    </nav>
    <!-- End Navbar -->
