<style>
    .wrap-header-mobile {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.btn-show-menu-mobile {
    display: flex;
    align-items: center;
    position: relative;
}

.btn-auth-mobile {
    display: none; /* Hide logout button by default on mobile */
}

/* Display logout button only on mobile and align it to the right */
@media (max-width: 768px) {
    .btn-auth-mobile {
        display: block;
        margin-left: auto; /* Align to the right */
        padding: 0 15px;
        color: #007BFF;
        font-weight: bold;
        text-decoration: none;
    }
}
</style>

<header class="header-v2">
    <!-- Header desktop -->
    <div class="container-menu-desktop trans-03">
        <div class="wrap-menu-desktop">
            <nav class="limiter-menu-desktop p-l-45">

                <!-- Menu desktop -->
                <div class="menu-desktop">
                    <ul class="main-menu">

                        <li>
                            <a href="index.html">Home</a>
                        </li>

                        <li class="label1" data-label1="hot">
                            <a href="product.html">Membership</a>
                        </li>
                    </ul>
                </div>	

                <div class="wrap-icon-header flex-w flex-r-m h-full">
                    @auth
                    <a href="{{route('landing.profile')}}" class="flex-c-m trans-04 p-lr-25" >
                        {{ Auth::user()->name }}
                    </a>
                    <a href="{{ route('logout') }}" class="flex-c-m trans-04 p-lr-25" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                    @else
                    <a href="{{ route('login') }}" class="flex-c-m trans-04 p-lr-25">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="flex-c-m trans-04 p-lr-25">
                        Register
                    </a>
                    @endauth
                </div>
            </nav>
        </div>	
    </div>

    <!-- Header Mobile -->
    <div class="wrap-header-mobile">
        <!-- Button show menu -->
        <div class="btn-show-menu-mobile hamburger hamburger--squeeze">
            <span class="hamburger-box">
                <span class="hamburger-inner"></span>
            </span>
        </div>
        @auth
        <li>
            <a href="{{ route('logout')}}" class="btn-auth-mobile" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Logout
            </a>
        </li>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
        @else

        <li>
            <a href="{{ route('login')}}" class="btn-auth-mobile">Login</a>
        </li>
        
        @endauth
        
    </div>


    <!-- Menu Mobile -->
    <div class="menu-mobile">
        <ul class="main-menu-m">

            <li>
                <a href="{{route('landing.profile')}}">profile</a>
            </li>
            <li>
                <a href="{{ route('landing.index') }}">Home</a>
            </li>

            <li>
                <a href="product.html" class="label1 rs1" data-label1="hot">Membership</a>
            </li>
        </ul>
    </div>
</header>