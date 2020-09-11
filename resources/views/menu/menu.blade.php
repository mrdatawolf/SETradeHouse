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
    <div class="container">
        <a  class="navbar-brand" href="#"><img src="/img/SETradeHouse_logo_core.png" alt="Logo" title="Logo" style="width: 4em;"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main_nav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="main_nav">

            <ul class="navbar-nav">
                @guest
                    <li class="nav-item">
                        <button class="nav-link dropdown-item" onclick="window.location.href='{{ route("login") }}';">
                            {{ __('Login') }}
                        </button>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <button class="nav-link dropdown-item" onclick="window.location.href='{{ route("register") }}';">
                                {{ __('Register') }}
                            </button>
                        </li>
                    @endif
                @else
                    <li class="nav-item">
                        <button class="nav-link dropdown-item" onclick="window.location.href='{{ route('home') }}';">
                            {{ __('Home') }}
                        </button>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">Transactions</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#"> Orders &raquo </a>
                                <ul class="submenu dropdown-menu">
                                    <li><button class="dropdown-item" onclick="window.location.href='{{ route("orders.ores") }}';">Ores</button></li>
                                    <li><button class="dropdown-item" onclick="window.location.href='{{ route("orders.ingots") }}';">Ingots</button></li>
                                    <li><button class="dropdown-item" onclick="window.location.href='{{ route("orders.components") }}';">Components</button></li>
                                    <li><button class="dropdown-item" onclick="window.location.href='{{ route("orders.tools") }}';">Tools</button></li>
                                </ul>
                            </li>
                            <li><a class="dropdown-item" href="#"> Offers &raquo </a>
                                <ul class="submenu dropdown-menu">
                                    <li><button class="dropdown-item" onclick="window.location.href='{{ route("offers.ores") }}';">Ores</button></li>
                                    <li><button class="dropdown-item" onclick="window.location.href='{{ route("offers.ingots") }}';">Ingots</button></li>
                                    <li><button class="dropdown-item" onclick="window.location.href='{{ route("offers.components") }}';">Components</button></li>
                                    <li><button class="dropdown-item" onclick="window.location.href='{{ route("offers.tools") }}';">Tools</button></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">Stores</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#"> General &raquo </a>
                                <ul class="submenu dropdown-menu">
                                    <li><button class="nav-link dropdown-item" onclick="window.location.href='{{ route('stores') }}';">Personal</button></li>
                                    <li><button class="nav-link dropdown-item" onclick="window.location.href='{{ route('stores.world') }}';">World</button></li>
                                    <li><button class="nav-link dropdown-item" onclick="window.location.href='{{ route('stores.server') }}';">Server</button></li>
                                </ul>
                            </li>
                            <li><a class="dropdown-item" href="#"> Profit/Loss &raquo </a>
                                <ul class="submenu dropdown-menu">
                                    <li><button class="nav-link dropdown-item" onclick="window.location.href='{{ route('profitvsloss') }}';">Personal</button></li>
                                    <li><button class="nav-link dropdown-item" onclick="window.location.href='{{ route('profitvsloss.world') }}';">World</button></li>
                                    <li><button class="nav-link dropdown-item" onclick="window.location.href='{{ route('profitvsloss.server') }}';">Server</button></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                <?php /*
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">Trends</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#"> Stores &raquo </a>
                                <ul class="submenu dropdown-menu">
                                    <li><button class="nav-link dropdown-item" onclick="window.location.href='{{ route('trends.stores') }}';">Personal</button></li>
                                    <li><button class="nav-link dropdown-item" onclick="window.location.href='{{ route('trends.stores.world') }}';">World</button></li>
                                    <li><button class="nav-link dropdown-item" onclick="window.location.href='{{ route('trends.stores.server') }}';">Server</button></li>
                                </ul>
                            </li>
                            <li><a class="dropdown-item" href="#"> Ores &raquo </a>
                                <ul class="submenu dropdown-menu">
                                    <li><button class="nav-link dropdown-item" onclick="window.location.href='{{ route('trends.stores') }}';">Personal</button></li>
                                    <li><button class="nav-link dropdown-item" onclick="window.location.href='{{ route('trends.stores.world') }}';">World</button></li>
                                    <li><button class="nav-link dropdown-item" onclick="window.location.href='{{ route('trends.stores.server') }}';">Server</button></li>
                                </ul>
                            </li>
                            <li><a class="dropdown-item" href="#"> Ingots &raquo </a>
                                <ul class="submenu dropdown-menu">
                                    <li><button class="nav-link dropdown-item" onclick="window.location.href='{{ route('trends.stores') }}';">Personal</button></li>
                                    <li><button class="nav-link dropdown-item" onclick="window.location.href='{{ route('trends.stores.world') }}';">World</button></li>
                                    <li><button class="nav-link dropdown-item" onclick="window.location.href='{{ route('trends.stores.server') }}';">Server</button></li>
                                </ul>
                            </li>
                            <li><a class="dropdown-item" href="#"> Components &raquo </a>
                                <ul class="submenu dropdown-menu">
                                    <li><button class="nav-link dropdown-item" onclick="window.location.href='{{ route('trends.stores') }}';">Personal</button></li>
                                    <li><button class="nav-link dropdown-item" onclick="window.location.href='{{ route('trends.stores.world') }}';">World</button></li>
                                    <li><button class="nav-link dropdown-item" onclick="window.location.href='{{ route('trends.stores.server') }}';">Server</button></li>
                                </ul>
                            </li>
                            <li><a class="dropdown-item" href="#"> Tools &raquo </a>
                                <ul class="submenu dropdown-menu">
                                    <li><button class="nav-link dropdown-item" onclick="window.location.href='{{ route('trends.stores') }}';">Personal</button></li>
                                    <li><button class="nav-link dropdown-item" onclick="window.location.href='{{ route('trends.stores.world') }}';">World</button></li>
                                    <li><button class="nav-link dropdown-item" onclick="window.location.href='{{ route('trends.stores.server') }}';">Server</button></li>
                                </ul>
                            </li>
                            <li><a class="dropdown-item" href="#"> Ammo &raquo </a>
                                <ul class="submenu dropdown-menu">
                                    <li><button class="nav-link dropdown-item" onclick="window.location.href='{{ route('trends.stores') }}';">Personal</button></li>
                                    <li><button class="nav-link dropdown-item" onclick="window.location.href='{{ route('trends.stores.world') }}';">World</button></li>
                                    <li><button class="nav-link dropdown-item" onclick="window.location.href='{{ route('trends.stores.server') }}';">Server</button></li>
                                </ul>
                            </li>
                            <li><a class="dropdown-item" href="#"> Bottles &raquo </a>
                                <ul class="submenu dropdown-menu">
                                    <li><button class="nav-link dropdown-item" onclick="window.location.href='{{ route('trends.stores') }}';">Personal</button></li>
                                    <li><button class="nav-link dropdown-item" onclick="window.location.href='{{ route('trends.stores.world') }}';">World</button></li>
                                    <li><button class="nav-link dropdown-item" onclick="window.location.href='{{ route('trends.stores.server') }}';">Server</button></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    */ ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">Other Info</a>
                        <ul class="dropdown-menu">
                            <li class="font-weight-bold">Current Server: {{ \App\Servers::find($currentUser->server_id)->title ?? '' }}</li>
                            <li class="font-weight-bold">Current World: 'N/A'</li>
                            <li class="font-weight-bold">Newest DB date: {{ Session::get('newest_db_record') }}</li>
                            <li class="font-weight-bold">Newest sync date: {{ Session::get('newest_sync_record') }}</li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">{{ $currentUser->username }}</a>
                        <ul class="dropdown-menu">
                            <li>Known on the server as: {{ $currentUser->server_username ?? $currentUser->username }}</a></li>
                            <li><button class="nav-link dropdown-item" onclick="window.location.href='{{ route('logout') }}';">{{ __('Logout') }}</button></li>
                        </ul>
                    </li>
                    <!--<li class="nav-item">
                        <a href="{{ route('stocklevels') }}" class="nav-link">Stock Levels</a>
                    </li>-->
                @endif
            </ul>
        </div> <!-- navbar-collapse.// -->
    </div>
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
