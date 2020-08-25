<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm fixed-top">
    <a href="#"><img src="/img/SETradeHouse_logo_core.png" alt="Logo" title="Logo" style="width: 4em;"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav mr-auto">
            @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>
                @if (Route::has('register'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                    </li>
                @endif
            @else
            <li class="nav-item">
                <a href="{{ route('home') }}" class="nav-link">Home</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link dropdown-toggle" id="navbarDropdownOffers" role="button" data-toggle="dropdown">Offers</a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownOffers">
                    <a href="{{ route('offers.ores') }}" class="dropdown-item">Ores</a>
                    <a href="{{ route('offers.ingots') }}" class="dropdown-item">Ingots</a>
                    <a href="{{ route('offers.components') }}" class="dropdown-item">Components</a>
                </div>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link dropdown-toggle" id="navbarDropdownOrders" role="button" data-toggle="dropdown">Orders</a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownOrders">
                    <a href="{{ route('orders.ores') }}" class="dropdown-item">Ores</a>
                    <a href="{{ route('orders.ingots') }}" class="dropdown-item">Ingots</a>
                    <a href="{{ route('orders.components') }}" class="dropdown-item">Components</a>
                </div>
            </li>
            <li class="nav-item">
                <a href="{{ route('stocklevels') }}" class="nav-link">Stock Levels</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link dropdown-toggle" id="navbarDropdownThrustToWeight" role="button" data-toggle="dropdown">Thrust to Weight</a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownThrustToWeight">
                    <a href="#" class="dropdown-item">Small Ship</a>
                    <a href="#" class="dropdown-item">Large Ship</a>
                </div>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">Tests</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link dropdown-toggle" id="navbarDropdownAccount" role="button" data-toggle="dropdown">{{ $currentUser->username ?? 'You are not logged in!' }}</a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownThrustToWeight">
                    <a href="#" class="dropdown-item">Current Server: {{ $currentUser->server_id ?? '' }}</a>
                    <a href="#" class="dropdown-item">Current World: 'work in progress'</a>
                    <a href="{{ url('/logout') }}"> logout </a>

                </div>
            </li>
            @endguest
        </ul>
    </div>
</nav>
