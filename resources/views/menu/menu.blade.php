<style>
    @media (min-width: 992px){
        .dropdown-menu .dropdown-toggle:after{
            border-top: .3em solid transparent;
            border-right: 0;
            border-bottom: .3em solid transparent;
            border-left: .3em solid;
        }
        .dropdown-menu .dropdown-menu{
            margin-left:0; margin-right: 0;
        }
        .dropdown-menu li{
            position: relative;
        }
        .nav-item .submenu{
            display: none;
            position: absolute;
            left:100%; top:-7px;
        }
        .nav-item .submenu-left{
            right:100%; left:auto;
        }
        .dropdown-menu > li:hover{ background-color: #f1f1f1 }
        .dropdown-menu > li:hover > .submenu{
            display: block;
        }
    }
</style>

<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm fixed-top">
    <a  class="navbar-brand" href="#"><img src="/img/SETradeHouse_logo_core.png" alt="Logo" title="Logo" style="width: 4em;"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main_nav">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="main_nav">

        <ul class="navbar-nav">
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
                <li class="nav-item"><a href="{{ route('home') }}" class="nav-link">Home</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">Transactions</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#"> Orders &raquo </a>
                            <ul class="submenu dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('orders.ores') }}">Ores</a></li>
                                <li><a class="dropdown-item" href="{{ route('orders.ingots') }}">Ingots</a></li>
                                <li><a class="dropdown-item" href="{{ route('orders.components') }}">Components</a></li>
                            </ul>
                        </li>
                        <li><a class="dropdown-item" href="#"> Offers &raquo </a>
                            <ul class="submenu dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('offers.ores') }}">Ores</a></li>
                                <li><a class="dropdown-item" href="{{ route('offers.ingots') }}">Ingots</a></li>
                                <li><a class="dropdown-item" href="{{ route('offers.components') }}">Components</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">Stores</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('stores') }}"> Your</a></li>
                        <li><a class="dropdown-item" href="{{ route('stores.world') }}">World</a></li>
                        <li><a class="dropdown-item" href="{{ route('stores.server') }}">Server</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">{{ $currentUser->username }}</a>
                    <ul class="dropdown-menu">
                        <li>Current Server: {{ $currentUser->server_id ?? '' }}</li>
                        <li>Current World: 'work in progress'</li>
                        <li>Known on the server as: {{ $currentUser->server_username ?? $currentUser->username }}</a></li>
                    </ul>
                </li>
                <!--<li class="nav-item">
                    <a href="{{ route('stocklevels') }}" class="nav-link">Stock Levels</a>
                </li>-->
            @endif
        </ul>
    </div> <!-- navbar-collapse.// -->
</nav>

<script>
    // Prevent closing from click inside dropdown
    $(document).on('click', '.dropdown-menu', function (e) {
        e.stopPropagation();
    });

    // make it as accordion for smaller screens
    if ($(window).width() < 992) {
        $('.dropdown-menu a').click(function(e){
            e.preventDefault();
            if($(this).next('.submenu').length){
                $(this).next('.submenu').toggle();
            }
            $('.dropdown').on('hide.bs.dropdown', function () {
                $(this).find('.submenu').hide();
            })
        });
    }
</script>
